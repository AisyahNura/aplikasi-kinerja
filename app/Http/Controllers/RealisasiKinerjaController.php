<?php

namespace App\Http\Controllers;

use App\Models\RealisasiKinerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * RealisasiKinerjaController - Controller untuk mengelola realisasi kinerja staff
 * 
 * FLOW SISTEM REALISASI KINERJA:
 * 1. Staff memilih tugas dan periode (tahun/triwulan)
 * 2. Input realisasi kinerja (kuantitas, waktu, kualitas, bukti)
 * 3. Simpan sebagai draft atau kirim langsung ke KASI
 * 4. KASI review dan berikan komentar/penilaian
 * 5. Staff dapat lihat riwayat dan komentar
 * 
 * STATUS REALISASI:
 * - draft: Belum dikirim ke KASI
 * - dikirim: Sudah dikirim ke KASI untuk review
 * - selesai: Sudah direview dan disetujui KASI
 */
class RealisasiKinerjaController extends Controller
{
    /**
     * Tampilkan form realisasi kinerja
     * FLOW:
     * 1. Staff memilih tahun dan triwulan
     * 2. Pilih tugas yang akan diinput realisasinya
     * 3. Tampilkan form input untuk setiap tugas
     */
    public function create(Request $request)
    {
        $tahun = $request->get('tahun');
        $triwulan = $request->get('triwulan');
        $tugasIds = $request->get('tugas_ids', []);

        // Ambil data tugas (dalam implementasi nyata, ini dari database)
        $tasks = [
            ['id' => 1, 'name' => 'Menyusun laporan bulanan', 'target_kuantitas' => 1, 'target_waktu' => 30],
            ['id' => 2, 'name' => 'Membuat presentasi kinerja', 'target_kuantitas' => 2, 'target_waktu' => 10],
            ['id' => 3, 'name' => 'Mengelola dokumen proyek', 'target_kuantitas' => 5, 'target_waktu' => 20],
        ];

        // Filter tugas berdasarkan yang dipilih
        $selectedTasks = collect($tasks)->whereIn('id', $tugasIds)->values();

        return view('realisasi-kinerja.create', compact('tahun', 'triwulan', 'selectedTasks'));
    }

    /**
     * Simpan realisasi kinerja (batch insert)
     * FLOW:
     * 1. Validasi input dari form
     * 2. Cek apakah sudah ada data untuk periode yang sama
     * 3. Update data existing atau insert data baru
     * 4. Set status menjadi 'dikirim'
     * 5. Commit transaction dan redirect
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|integer|min:2020|max:2030',
            'triwulan' => 'required|in:I,II,III,IV',
            'realisasi' => 'required|array|min:1',
            'realisasi.*.tugas_id' => 'required|integer',
            'realisasi.*.target_kuantitas' => 'required|integer|min:1',
            'realisasi.*.realisasi_kuantitas' => 'required|integer|min:0',
            'realisasi.*.target_waktu' => 'required|integer|min:1',
            'realisasi.*.realisasi_waktu' => 'required|integer|min:0',
            'realisasi.*.kualitas' => 'required|integer|min:0|max:100',
            'realisasi.*.link_bukti' => 'nullable|url',
        ], [
            'realisasi.*.realisasi_kuantitas.required' => 'Realisasi kuantitas wajib diisi',
            'realisasi.*.realisasi_waktu.required' => 'Realisasi waktu wajib diisi',
            'realisasi.*.kualitas.required' => 'Kualitas wajib diisi',
            'realisasi.*.kualitas.min' => 'Kualitas minimal 0%',
            'realisasi.*.kualitas.max' => 'Kualitas maksimal 100%',
            'realisasi.*.link_bukti.url' => 'Link bukti harus berupa URL yang valid',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $userId = Auth::id();
            $tahun = $request->input('tahun');
            $triwulan = $request->input('triwulan');
            $realisasiData = $request->input('realisasi');

            $dataToInsert = [];

            foreach ($realisasiData as $index => $data) {
                // Cek apakah sudah ada data untuk user, tahun, triwulan, dan tugas ini
                $existing = RealisasiKinerja::where('user_id', $userId)
                    ->where('tahun', $tahun)
                    ->where('triwulan', $triwulan)
                    ->where('tugas_id', $data['tugas_id'])
                    ->first();

                if ($existing) {
                    // Update data yang sudah ada
                    $existing->update([
                        'target_kuantitas' => $data['target_kuantitas'],
                        'realisasi_kuantitas' => $data['realisasi_kuantitas'],
                        'target_waktu' => $data['target_waktu'],
                        'realisasi_waktu' => $data['realisasi_waktu'],
                        'kualitas' => $data['kualitas'],
                        'link_bukti' => $data['link_bukti'] ?? null,
                        'status' => 'dikirim', // Update status menjadi dikirim
                    ]);
                } else {
                    // Insert data baru
                    $dataToInsert[] = [
                        'user_id' => $userId,
                        'tugas_id' => $data['tugas_id'],
                        'tahun' => $tahun,
                        'triwulan' => $triwulan,
                        'target_kuantitas' => $data['target_kuantitas'],
                        'realisasi_kuantitas' => $data['realisasi_kuantitas'],
                        'target_waktu' => $data['target_waktu'],
                        'realisasi_waktu' => $data['realisasi_waktu'],
                        'kualitas' => $data['kualitas'],
                        'link_bukti' => $data['link_bukti'] ?? null,
                        'status' => 'dikirim',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Batch insert untuk data baru
            if (!empty($dataToInsert)) {
                RealisasiKinerja::insert($dataToInsert);
            }

            DB::commit();

            return redirect()->route('realisasi-kinerja.index')
                ->with('success', 'Data realisasi kinerja berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Simpan draft realisasi kinerja
     */
    public function storeDraft(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|integer|min:2020|max:2030',
            'triwulan' => 'required|in:I,II,III,IV',
            'realisasi' => 'required|array|min:1',
            'realisasi.*.tugas_id' => 'required|integer',
            'realisasi.*.target_kuantitas' => 'required|integer|min:1',
            'realisasi.*.realisasi_kuantitas' => 'nullable|integer|min:0',
            'realisasi.*.target_waktu' => 'required|integer|min:1',
            'realisasi.*.realisasi_waktu' => 'nullable|integer|min:0',
            'realisasi.*.kualitas' => 'nullable|integer|min:0|max:100',
            'realisasi.*.link_bukti' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $userId = Auth::id();
            $tahun = $request->input('tahun');
            $triwulan = $request->input('triwulan');
            $realisasiData = $request->input('realisasi');

            foreach ($realisasiData as $data) {
                $existing = RealisasiKinerja::where('user_id', $userId)
                    ->where('tahun', $tahun)
                    ->where('triwulan', $triwulan)
                    ->where('tugas_id', $data['tugas_id'])
                    ->first();

                if ($existing) {
                    // Update draft yang sudah ada
                    $existing->update([
                        'target_kuantitas' => $data['target_kuantitas'],
                        'realisasi_kuantitas' => $data['realisasi_kuantitas'] ?? 0,
                        'target_waktu' => $data['target_waktu'],
                        'realisasi_waktu' => $data['realisasi_waktu'] ?? 0,
                        'kualitas' => $data['kualitas'] ?? 100,
                        'link_bukti' => $data['link_bukti'] ?? null,
                        'status' => 'draft',
                    ]);
                } else {
                    // Insert draft baru
                    RealisasiKinerja::create([
                        'user_id' => $userId,
                        'tugas_id' => $data['tugas_id'],
                        'tahun' => $tahun,
                        'triwulan' => $triwulan,
                        'target_kuantitas' => $data['target_kuantitas'],
                        'realisasi_kuantitas' => $data['realisasi_kuantitas'] ?? 0,
                        'target_waktu' => $data['target_waktu'],
                        'realisasi_waktu' => $data['realisasi_waktu'] ?? 0,
                        'kualitas' => $data['kualitas'] ?? 100,
                        'link_bukti' => $data['link_bukti'] ?? null,
                        'status' => 'draft',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('realisasi-kinerja.index')
                ->with('success', 'Draft realisasi kinerja berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->with('error', 'Terjadi kesalahan saat menyimpan draft: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Tampilkan daftar realisasi kinerja
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $tahun = $request->get('tahun', date('Y'));
        $triwulan = $request->get('triwulan', 'I');

        $realisasiKinerja = RealisasiKinerja::byUser($userId)
            ->byPeriod($tahun, $triwulan)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('realisasi-kinerja.index', compact('realisasiKinerja', 'tahun', 'triwulan'));
    }
} 