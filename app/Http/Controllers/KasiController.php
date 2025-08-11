<?php

namespace App\Http\Controllers;

use App\Models\RealisasiKinerja;
use App\Models\User;
use App\Models\Comment;
use App\Models\PenilaianStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * KasiController - Controller untuk mengelola fungsi-fungsi KASI (Kepala Seksi)
 * 
 * FLOW SISTEM KASI:
 * 1. Login KASI -> Validasi role -> Set session -> Redirect ke dashboard
 * 2. Dashboard -> Tampilkan data staff dan statistik kinerja
 * 3. Daftar Staff -> Tampilkan semua staff yang berada di bawah KASI
 * 4. Penilaian Staff -> KASI dapat menilai kinerja staff setiap triwulan
 * 5. Detail Tugas -> Lihat detail tugas yang dikerjakan staff
 * 6. Profil -> Lihat dan edit profil KASI
 * 7. Logout -> Hapus session dan redirect ke login
 */
class KasiController extends Controller
{
    /**
     * Tampilkan halaman login KASI
     * FLOW: User mengakses /login/kasi -> Tampilkan form login
     */
    public function showLogin()
    {
        return view('auth.login-kasi');
    }

    /**
     * Handle login KASI
     * FLOW: 
     * 1. Validasi input email dan password
     * 2. Coba authenticate dengan email dan NIP
     * 3. Cek role user harus 'kasi'
     * 4. Set session data (kasi_logged_in, kasi_name, kasi_id)
     * 5. Redirect ke dashboard dengan pesan sukses
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
     * FLOW:
     * 1. Cek session login KASI
     * 2. Ambil data KASI dengan relasi staff
     * 3. Ambil data Kepala untuk informasi struktur
     * 4. Hitung statistik staff (total, aktif, nonaktif)
     * 5. Tampilkan dashboard dengan semua data
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
     * FLOW:
     * 1. Cek session login KASI
     * 2. Tentukan tahun dan triwulan (default: current)
     * 3. Ambil semua staff yang berada di bawah KASI ini
     * 4. Ambil data penilaian yang sudah ada untuk periode tersebut
     * 5. Tampilkan form penilaian untuk setiap staff
     */
    public function penilaian()
    {
        // Cek apakah sudah login
        if (!session('kasi_logged_in')) {
            return redirect('/login/kasi')
                           ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get current year and quarter
        $currentYear = date('Y');
        $currentMonth = date('n');
        $currentQuarter = ceil($currentMonth / 3);
        $quarterMap = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV'];
        
        // Get requested year and quarter, default to current
        $tahun = request('tahun', $currentYear);
        $triwulan = request('triwulan', $quarterMap[$currentQuarter]);

        $kasiId = session('kasi_id');

        try {
            // Get current Kasi data with their staff
            $kasi = User::with(['staffs' => function($query) {
                $query->select('users.*')
                      ->where('status', 'aktif')
                      ->orderBy('name');
            }])->find($kasiId);
            
            if (!$kasi || !$kasi->isKasi()) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Akses tidak valid'
                    ], 403);
                }
                return redirect('/login/kasi')
                               ->with('error', 'Akses tidak valid.');
            }

            // Get all staff assigned to this Kasi
            $staffList = $kasi->staffs;
            
            \Log::info('Kasi staff data:', [
                'kasi_id' => $kasiId,
                'kasi_name' => $kasi->name,
                'staff_count' => $staffList->count(),
                'staff_ids' => $staffList->pluck('id')->toArray(),
                'staff_names' => $staffList->pluck('name')->toArray()
            ]);
            
            if ($staffList->isEmpty()) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada staff yang ditugaskan'
                    ]);
                }
                return view('kasi.penilaian', [
                    'staffList' => collect(),
                    'penilaian' => collect(),
                    'tahun' => $tahun,
                    'triwulan' => $triwulan
                ]);
            }

            // Get existing penilaian for this period
            $penilaian = PenilaianStaff::where('kasi_id', $kasiId)
                ->where('tahun', $tahun)
                ->where('triwulan', $triwulan)
                ->get()
                ->keyBy('staff_id');

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'staffList' => $staffList,
                    'penilaian' => $penilaian,
                    'periode' => [
                        'tahun' => $tahun,
                        'triwulan' => $triwulan
                    ]
                ]);
            }

            return view('kasi.penilaian', compact('staffList', 'penilaian', 'tahun', 'triwulan'));

        } catch (\Exception $e) {
            \Log::error('Error in penilaian: ' . $e->getMessage());
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memuat data: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Terjadi kesalahan saat memuat data');
        }
    }

    /**
     * Simpan penilaian staff
     * FLOW:
     * 1. Validasi input (staff_id, rating, komentar, tahun, triwulan)
     * 2. Cek apakah staff adalah bawahan dari KASI ini
     * 3. Simpan atau update penilaian ke database
     * 4. Return response JSON sukses/error
     */
    public function simpanPenilaian(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:users,id',
            'rating' => 'required|in:1,2,3',
            'komentar' => 'required|string|max:1000',
            'tahun' => 'required|integer|min:2020|max:2100',
            'triwulan' => 'required|in:I,II,III,IV'
        ]);

        try {
            $kasiId = session('kasi_id');
            
            // Cek apakah staff adalah bawahan dari Kasi ini
            $kasi = User::with('staffs')->find($kasiId);
            $isValidStaff = $kasi->staffs->contains('id', $request->staff_id);
            
            if (!$isValidStaff) {
                return response()->json([
                    'success' => false,
                    'message' => 'Staff tidak valid'
                ], 403);
            }

            // Simpan atau update penilaian
            $penilaian = PenilaianStaff::updateOrCreate(
                [
                    'staff_id' => $request->staff_id,
                    'kasi_id' => $kasiId,
                    'tahun' => $request->tahun,
                    'triwulan' => $request->triwulan
                ],
                [
                    'rating' => $request->rating,
                    'komentar' => $request->komentar
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Penilaian berhasil disimpan',
                'data' => $penilaian
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error menyimpan penilaian:', [
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
     * Get riwayat penilaian for a specific period
     * FLOW:
     * 1. Cek session login KASI
     * 2. Ambil tahun dan triwulan dari request
     * 3. Ambil semua staff yang berada di bawah KASI
     * 4. Ambil komentar/rating untuk periode tersebut
     * 5. Format data dan return JSON
     */
    public function riwayatPenilaian(Request $request)
    {
        if (!session('kasi_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tahun = $request->get('tahun', date('Y'));
        $triwulan = $request->get('triwulan', 'IV');
        $kasiId = session('kasi_id');

        // Get all staff assigned to this Kasi
        $kasi = User::with('staffs')->find($kasiId);
        $staffIds = $kasi->staffs()->pluck('id');

        // Get comments/ratings for this period
        $comments = Comment::whereIn('user_id', $staffIds)
            ->where('created_by', $kasiId)
            ->whereHas('realisasiKinerja', function($q) use ($tahun, $triwulan) {
                $q->where('tahun', $tahun)
                  ->where('triwulan', $triwulan);
            })
            ->with(['user', 'realisasiKinerja'])
            ->get();

        // Format the data for the view
        $riwayat = $comments->map(function ($comment) {
            return [
                'id' => $comment->user_id,
                'nama' => $comment->user->name,
                'penilaian' => $comment->rating,
                'komentar' => $comment->komentar,
                'tanggal' => $comment->created_at->format('Y-m-d')
            ];
        });

        return response()->json([
            'riwayat' => $riwayat
        ]);
    }



    /**
     * Tampilkan detail tugas
     * FLOW: Tampilkan detail tugas staff dengan data dummy untuk demo
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
     * Tampilkan daftar staff yang berada di bawah Kasi ini
     * FLOW:
     * 1. Cek session login KASI
     * 2. Ambil data KASI yang sedang login
     * 3. Ambil semua staff yang berada di bawah KASI (relasi staffs)
     * 4. Hitung statistik (total, aktif, nonaktif)
     * 5. Tampilkan view dengan data staff dan statistik
     */
    public function daftarStaff()
    {
        if (!session('kasi_logged_in')) {
            return redirect('/login/kasi')
                           ->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $kasiId = session('kasi_id');
        $kasi = User::find($kasiId);
        
        // Ambil semua staff yang berada di bawah Kasi ini
        $staffList = $kasi->staffs()->get();
        
        // Statistik
        $totalStaff = $staffList->count();
        $staffAktif = $staffList->where('status', 'aktif')->count();
        $staffNonaktif = $staffList->where('status', 'nonaktif')->count();
        
        // Jika field status tidak ada, gunakan default
        if (!$staffList->first() || !isset($staffList->first()->status)) {
            $staffAktif = $totalStaff;
            $staffNonaktif = 0;
        }
        
        return view('kasi.daftar-staff', compact('kasi', 'staffList', 'totalStaff', 'staffAktif', 'staffNonaktif'));
    }

    /**
     * Tampilkan halaman profil Kasi
     * FLOW: Tampilkan halaman profil KASI
     */
    public function profil()
    {
        return view('kasi.profil');
    }

    /**
     * Logout Kasi
     * FLOW:
     * 1. Hapus authentication (Auth::logout)
     * 2. Hapus session data (kasi_logged_in, kasi_name, kasi_id)
     * 3. Redirect ke halaman login dengan pesan sukses
     */
    public function logout()
    {
        Auth::logout();
        session()->forget(['kasi_logged_in', 'kasi_name', 'kasi_id']);
        
        return redirect('/login/kasi')
                       ->with('success', 'Anda telah berhasil logout.');
    }
} 