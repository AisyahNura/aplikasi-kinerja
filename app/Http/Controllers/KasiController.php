<?php

namespace App\Http\Controllers;

use App\Models\RealisasiKinerja;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KasiController extends Controller
{
    /**
     * Tampilkan halaman login KASI
     */
    public function showLogin()
    {
        return view('auth.login-kasi');
    }

    /**
     * Handle login KASI
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Attempt authentication using email and NIP as password
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Check if user has kasi role
            if ($user->role !== 'kasi') {
                Auth::logout();
                Log::warning('Kasi login failed - wrong role:', ['email' => $request->email, 'role' => $user->role]);
                return back()->withErrors([
                    'email' => 'Email atau NIP salah.',
                ])->withInput($request->only('email'));
            }

            // Set session data
            session(['kasi_logged_in' => true]);
            session(['kasi_name' => $user->name]);
            session(['kasi_id' => $user->id]);
            
            Log::info('Kasi login successful:', ['user_id' => $user->id, 'email' => $user->email]);
            
            return redirect()->route('kasi.dashboard')
                           ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        Log::warning('Kasi login failed:', ['email' => $request->email]);

        return back()->withErrors([
            'email' => 'Email atau NIP salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Tampilkan dashboard KASI
     */
    public function dashboard()
    {
        // Cek apakah sudah login
        if (!session('kasi_logged_in')) {
            return redirect('/login/kasi')
                           ->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Get current Kasi data dengan relasi staff
        $kasiId = session('kasi_id');
        $kasi = User::with('staffs')->find($kasiId);
        
        if (!$kasi || !$kasi->isKasi()) {
            return redirect('/login/kasi')
                           ->with('error', 'Akses tidak valid.');
        }
        
        // Get Kepala data
        $kepala = User::kepala()->first();
        
        // Kasi profile data
        $kasiName = $kasi->name;
        $kasiNip = $kasi->nip;
        $kasiPangkat = 'Penata Tk.I / III/d';
        $kasiJabatan = $kasi->jabatan;
        $kasiUnitKerja = 'Kantor Kementerian Agama Kabupaten Jombang';
        
        // Kepala profile data
        $kepalaName = $kepala ? $kepala->name : 'Dr. MUHAJIR, S.Pd., M.Ag';
        $kepalaNip = $kepala ? $kepala->nip : '197304131999031003';
        $kepalaPangkat = 'Pembina Tingkat I / IV/b';
        $kepalaJabatan = $kepala ? $kepala->jabatan : 'Kepala Kantor Kementerian Agama Kabupaten Jombang';
        $kepalaUnitKerja = 'Kantor Kementerian Agama Kabupaten Jombang';
        
        // Data staff di bawah kasi ini
        $totalStaff = $kasi->staffs()->count();
        $staffList = $kasi->staffs;
        
        return view('kasi.dashboard', compact(
            'kasiName', 'kasiNip', 'kasiPangkat', 'kasiJabatan', 'kasiUnitKerja',
            'kepalaName', 'kepalaNip', 'kepalaPangkat', 'kepalaJabatan', 'kepalaUnitKerja',
            'totalStaff', 'staffList'
        ));
    }

    /**
     * Tampilkan halaman penilaian kinerja staf
     */
    public function penilaian()
    {
        // Cek apakah sudah login
        if (!session('kasi_logged_in')) {
            return redirect('/login/kasi')
                           ->with('error', 'Silakan login terlebih dahulu.');
        }

        $tahun = request('tahun', 2025);
        $triwulan = request('triwulan', 'I');
        $kasiId = session('kasi_id');

        // Get current Kasi data
        $kasi = User::with('staffs')->find($kasiId);
        
        if (!$kasi || !$kasi->isKasi()) {
            return redirect('/login/kasi')
                           ->with('error', 'Akses tidak valid.');
        }

        // Ambil ID staff yang di bawah kasi ini
        $staffIds = $kasi->staffs()->pluck('id');

        // Ambil data realisasi kinerja yang sudah dikirim (status: dikirim)
        // Hanya dari staff yang di bawah kasi ini
        try {
            $realisasiKinerja = RealisasiKinerja::with(['user', 'task'])
                ->where('status', 'dikirim')
                ->where('tahun', $tahun)
                ->where('triwulan', $triwulan)
                ->whereIn('user_id', $staffIds) // Filter hanya staff di bawah kasi ini
                ->get();
                
            Log::info('RealisasiKinerja query result:', [
                'count' => $realisasiKinerja->count(),
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'kasi_id' => $kasiId,
                'staff_ids' => $staffIds->toArray()
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching RealisasiKinerja:', [
                'error' => $e->getMessage(),
                'tahun' => $tahun,
                'triwulan' => $triwulan
            ]);
            $realisasiKinerja = collect([]);
        }

        // Ambil komentar yang sudah ada untuk mapping penilaian
        $comments = Comment::whereIn('realisasi_kinerja_id', $realisasiKinerja->pluck('id'))
            ->where('created_by', session('kasi_id', 1))
            ->get()
            ->keyBy('realisasi_kinerja_id');

        // Konversi ke format yang dibutuhkan view
        try {
            $tugasStaf = $realisasiKinerja->map(function ($realisasi) use ($comments) {
                $comment = $comments->get($realisasi->id);
                
                // Konversi rating ke penilaian text
                $penilaian = null;
                if ($comment) {
                    switch ($comment->rating) {
                        case 1:
                            $penilaian = 'dibawah';
                            break;
                        case 2:
                            $penilaian = 'sesuai';
                            break;
                        case 3:
                            $penilaian = 'melebihi';
                            break;
                    }
                }

                return [
                    'id' => $realisasi->id,
                    'nama_staf' => $realisasi->user->name ?? 'Staff',
                    'nama_tugas' => $realisasi->task->nama_tugas ?? 'Tugas',
                    'target_kuantitas' => $realisasi->target_kuantitas ?? 0,
                    'realisasi_kuantitas' => $realisasi->realisasi_kuantitas ?? 0,
                    'target_waktu' => $realisasi->target_waktu ?? 0,
                    'realisasi_waktu' => $realisasi->realisasi_waktu ?? 0,
                    'link_bukti' => $realisasi->link_bukti ?? '#',
                    'status' => $realisasi->status,
                    'penilaian' => $penilaian,
                    'komentar' => $comment ? $comment->komentar : ''
                ];
            })->toArray();
            
            Log::info('TugasStaf mapping result:', [
                'count' => count($tugasStaf),
                'sample' => count($tugasStaf) > 0 ? $tugasStaf[0] : null
            ]);
        } catch (\Exception $e) {
            Log::error('Error mapping TugasStaf:', [
                'error' => $e->getMessage()
            ]);
            $tugasStaf = [];
        }
        
        // Jika tidak ada data, gunakan dummy data untuk testing
        if (empty($tugasStaf)) {
            Log::info('No data found, using dummy data for testing');
            $tugasStaf = [
                [
                    'id' => 1,
                    'nama_staf' => 'Andi Saputra',
                    'nama_tugas' => 'Menyusun laporan bulanan',
                    'target_kuantitas' => 1,
                    'realisasi_kuantitas' => 1,
                    'target_waktu' => 30,
                    'realisasi_waktu' => 25,
                    'link_bukti' => 'https://drive.google.com/file/d/123',
                    'status' => 'dikirim',
                    'penilaian' => null
                ],
                [
                    'id' => 2,
                    'nama_staf' => 'Budi Santoso',
                    'nama_tugas' => 'Membuat presentasi kinerja',
                    'target_kuantitas' => 2,
                    'realisasi_kuantitas' => 2,
                    'target_waktu' => 10,
                    'realisasi_waktu' => 8,
                    'link_bukti' => 'https://drive.google.com/file/d/456',
                    'status' => 'dikirim',
                    'penilaian' => 'sesuai'
                ]
            ];
        }

        return view('kasi.penilaian', compact('tugasStaf', 'tahun', 'triwulan'));
    }

    /**
     * Simpan penilaian kinerja
     */
    public function simpanPenilaian(Request $request)
    {
        $request->validate([
            'tugas_id' => 'required|integer',
            'penilaian' => 'required|in:dibawah,sesuai,melebihi',
            'komentar' => 'nullable|string'
        ]);

        try {
            // Konversi penilaian ke nilai numerik
            $ratingMap = [
                'dibawah' => 1,
                'sesuai' => 2,
                'melebihi' => 3
            ];
            
            $rating = $ratingMap[$request->penilaian];
            
            // Ambil realisasi kinerja berdasarkan tugas_id
            $realisasiKinerja = RealisasiKinerja::find($request->tugas_id);
            
            if (!$realisasiKinerja) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tugas tidak ditemukan'
                ], 404);
            }
            
            // Cek apakah sudah ada komentar untuk realisasi ini
            $existingComment = Comment::where('realisasi_kinerja_id', $realisasiKinerja->id)
                                                  ->where('created_by', session('kasi_id', 1))
                                                  ->first();
            
            if ($existingComment) {
                // Update komentar yang sudah ada
                $existingComment->update([
                    'rating' => $rating,
                    'komentar' => $request->komentar ?: $existingComment->komentar
                ]);
            } else {
                // Buat komentar baru
                Comment::create([
                    'user_id' => $realisasiKinerja->user_id,
                    'realisasi_kinerja_id' => $realisasiKinerja->id,
                    'rating' => $rating,
                    'komentar' => $request->komentar ?: 'Penilaian kinerja dari Kasi',
                    'created_by' => session('kasi_id', 1),
                    'is_read' => false
                ]);
            }
            
            // Update status realisasi kinerja menjadi 'verif'
            $realisasiKinerja->update(['status' => 'verif']);
            
            Log::info('Penilaian Kinerja berhasil disimpan:', [
                'tugas_id' => $request->tugas_id,
                'rating' => $rating,
                'penilaian' => $request->penilaian,
                'komentar' => $request->komentar
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Penilaian berhasil disimpan'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error menyimpan penilaian:', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan penilaian'
            ], 500);
        }
    }

    /**
     * Tampilkan detail tugas
     */
    public function detailTugas($id)
    {
        // Dummy data untuk detail tugas
        $tugas = [
            'id' => $id,
            'nama_staf' => 'Andi Saputra',
            'nama_tugas' => 'Menyusun laporan bulanan',
            'target_kuantitas' => 1,
            'realisasi_kuantitas' => 1,
            'target_waktu' => 30,
            'realisasi_waktu' => 25,
            'link_bukti' => 'https://drive.google.com/file/d/123',
            'status' => 'dikirim',
            'penilaian' => null,
            'deskripsi' => 'Menyusun laporan kinerja bulanan untuk evaluasi dan pelaporan ke atasan.',
            'tanggal_mulai' => '2025-01-01',
            'tanggal_selesai' => '2025-01-25',
            'kualitas' => 95,
            'komentar' => 'Laporan disusun dengan baik dan lengkap.'
        ];

        return view('kasi.detail-tugas', compact('tugas'));
    }

    /**
     * Tampilkan profil KASI
     */
    public function profil()
    {
        return view('kasi.profil');
    }

    /**
     * Logout Kasi
     */
    public function logout()
    {
        Auth::logout();
        session()->forget(['kasi_logged_in', 'kasi_name', 'kasi_id']);
        
        return redirect('/login/kasi')
                       ->with('success', 'Anda telah berhasil logout.');
    }
} 