<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\RealisasiKinerja;
use App\Models\KomentarKepala;
use App\Models\PenilaianKepala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class KepalaController extends Controller
{
    /**
     * Tampilkan halaman login Kepala
     */
    public function showLogin()
    {
        return view('auth.login-kepala');
    }

    /**
     * Handle login Kepala
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->role !== 'kepala') {
                Auth::logout();
                Log::warning('Kepala login failed - wrong role:', ['email' => $request->email, 'role' => $user->role]);
                return back()->withErrors([
                    'email' => 'Email atau password salah.',
                ])->withInput($request->only('email'));
            }

            session(['kepala_logged_in' => true]);
            session(['kepala_name' => $user->name]);
            session(['kepala_id' => $user->id]);
            
            Log::info('Kepala login successful:', ['user_id' => $user->id, 'email' => $user->email]);
            
            return redirect()->route('kepala.dashboard')
                           ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        Log::warning('Kepala login failed:', ['email' => $request->email]);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Tampilkan dashboard Kepala
     */
    public function dashboard()
    {
        if (!session('kepala_logged_in')) {
            return redirect('/login/kepala')
                           ->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $kepalaId = session('kepala_id');
        $kepala = User::find($kepalaId);
        
        // Statistik umum
        $totalKasi = User::where('role', 'kasi')->count();
        $totalStaff = User::where('role', 'staff')->count();
        $totalPenilaian = Comment::count();
        $totalRealisasi = RealisasiKinerja::count();
        
        // Data Kasi dan Staff terbaru
        $recentKasi = User::where('role', 'kasi')
                         ->orderBy('created_at', 'desc')
                         ->take(5)
                         ->get();
        
        $recentStaff = User::where('role', 'staff')
                          ->orderBy('created_at', 'desc')
                          ->take(5)
                          ->get();
        
        // Penilaian terbaru
        $recentPenilaian = Comment::with(['realisasiKinerja.task', 'createdBy', 'user'])
                                 ->orderBy('created_at', 'desc')
                                 ->take(5)
                                 ->get();
        
        return view('kepala.dashboard', compact(
            'kepala',
            'totalKasi',
            'totalStaff',
            'totalPenilaian',
            'totalRealisasi',
            'recentKasi',
            'recentStaff',
            'recentPenilaian'
        ));
    }

    /**
     * Tampilkan daftar Kasi dan Staff
     */
    public function dataPegawai(Request $request)
    {
        if (!session('kepala_logged_in')) {
            return redirect('/login/kepala');
        }

        $search = $request->get('search');
        $role = $request->get('role', 'all');

        $query = User::with(['kasi', 'staffs'])
                    ->whereIn('role', ['kasi', 'staff']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        $pegawai = $query->orderBy('role')
                        ->orderBy('name')
                        ->paginate(15);

        return view('kepala.data-pegawai', compact('pegawai', 'search', 'role'));
    }

    /**
     * Tampilkan monitoring penilaian kinerja
     */
    public function monitoringPenilaian(Request $request)
    {
        if (!session('kepala_logged_in')) {
            return redirect('/login/kepala');
        }

        $tahun = $request->get('tahun', date('Y'));
        $triwulan = $request->get('triwulan', $this->getCurrentQuarter());
        $kasiId = $request->get('kasi_id');

        // Query penilaian dengan filter dan relasi
        $query = Comment::with(['realisasiKinerja.task', 'createdBy', 'user.kasi'])
                       ->whereHas('realisasiKinerja', function($q) use ($tahun, $triwulan) {
                           $q->where('tahun', $tahun)
                             ->where('triwulan', $triwulan);
                       });

        if ($kasiId) {
            $query->where('created_by', $kasiId);
        }

        $penilaian = $query->orderBy('created_at', 'desc')
                          ->paginate(15);

        // Rata-rata nilai per staff dengan informasi atasan
        $rataRataStaff = Comment::with(['user.kasi'])
                               ->whereHas('realisasiKinerja', function($q) use ($tahun, $triwulan) {
                                   $q->where('tahun', $tahun)
                                     ->where('triwulan', $triwulan);
                               })
                               ->select('user_id', \DB::raw('AVG(rating) as rata_rata'), \DB::raw('COUNT(*) as total_penilaian'))
                               ->groupBy('user_id')
                               ->get();

        // Data untuk filter - hanya kasi yang punya staff
        $kasiList = User::where('role', 'kasi')->with('staffs')->get()->filter(function($kasi) {
            return $kasi->staffs->count() > 0;
        });

        // Statistik per kasi
        $statistikKasi = [];
        foreach ($kasiList as $kasi) {
            $staffIds = $kasi->staffs->pluck('id');
            $totalPenilaian = Comment::whereIn('user_id', $staffIds)
                                   ->whereHas('realisasiKinerja', function($q) use ($tahun, $triwulan) {
                                       $q->where('tahun', $tahun)
                                         ->where('triwulan', $triwulan);
                                   })
                                   ->count();
            
            $rataRata = Comment::whereIn('user_id', $staffIds)
                              ->whereHas('realisasiKinerja', function($q) use ($tahun, $triwulan) {
                                  $q->where('tahun', $tahun)
                                    ->where('triwulan', $triwulan);
                              })
                              ->avg('rating');

            $statistikKasi[] = [
                'kasi' => $kasi,
                'total_staff' => $kasi->staffs->count(),
                'total_penilaian' => $totalPenilaian,
                'rata_rata' => $rataRata ? round($rataRata, 2) : 0
            ];
        }

        return view('kepala.monitoring-penilaian', compact(
            'penilaian',
            'rataRataStaff',
            'tahun',
            'triwulan',
            'kasiId',
            'kasiList',
            'statistikKasi'
        ));
    }

    /**
     * Tampilkan form komentar umum
     */
    public function komentarUmum()
    {
        if (!session('kepala_logged_in')) {
            return redirect('/login/kepala');
        }

        $tahun = request('tahun', date('Y'));
        $triwulan = request('triwulan', $this->getCurrentQuarter());

        $komentar = KomentarKepala::where('tahun', $tahun)
                                 ->where('triwulan', $triwulan)
                                 ->first();

        return view('kepala.komentar-umum', compact('komentar', 'tahun', 'triwulan'));
    }

    /**
     * Simpan komentar umum
     */
    public function simpanKomentarUmum(Request $request)
    {
        if (!session('kepala_logged_in')) {
            return redirect('/login/kepala');
        }

        $request->validate([
            'tahun' => 'required|integer',
            'triwulan' => 'required|string',
            'komentar' => 'required|string|max:1000'
        ]);

        $komentar = KomentarKepala::updateOrCreate(
            [
                'tahun' => $request->tahun,
                'triwulan' => $request->triwulan
            ],
            [
                'komentar' => $request->komentar
            ]
        );

        return redirect()->route('kepala.komentar-umum')
                        ->with('success', 'Komentar umum berhasil disimpan!');
    }

    /**
     * Export laporan PDF
     */
    public function exportPDF(Request $request)
    {
        if (!session('kepala_logged_in')) {
            return redirect('/login/kepala');
        }

        $tahun = $request->get('tahun', date('Y'));
        $triwulan = $request->get('triwulan', $this->getCurrentQuarter());

        // Data untuk laporan
        $penilaian = Comment::with(['realisasiKinerja.task', 'createdBy', 'user'])
                           ->whereHas('realisasiKinerja', function($q) use ($tahun, $triwulan) {
                               $q->where('tahun', $tahun)
                                 ->where('triwulan', $triwulan);
                           })
                           ->get();

        $rataRataStaff = Comment::with('user')
                               ->whereHas('realisasiKinerja', function($q) use ($tahun, $triwulan) {
                                   $q->where('tahun', $tahun)
                                     ->where('triwulan', $triwulan);
                               })
                               ->select('user_id', DB::raw('AVG(rating) as rata_rata'), DB::raw('COUNT(*) as total_penilaian'))
                               ->groupBy('user_id')
                               ->get();

        $komentarKepala = KomentarKepala::where('tahun', $tahun)
                                       ->where('triwulan', $triwulan)
                                       ->first();

        $pdf = PDF::loadView('kepala.laporan-pdf', compact(
            'penilaian',
            'rataRataStaff',
            'komentarKepala',
            'tahun',
            'triwulan'
        ));

        return $pdf->download("laporan-penilaian-kinerja-{$tahun}-triwulan-{$triwulan}.pdf");
    }

    /**
     * Export laporan Excel
     */
    public function exportExcel(Request $request)
    {
        if (!session('kepala_logged_in')) {
            return redirect('/login/kepala');
        }

        $tahun = $request->get('tahun', date('Y'));
        $triwulan = $request->get('triwulan', $this->getCurrentQuarter());

        // Data untuk laporan
        $penilaian = Comment::with(['realisasiKinerja.task', 'createdBy', 'user'])
                           ->whereHas('realisasiKinerja', function($q) use ($tahun, $triwulan) {
                               $q->where('tahun', $tahun)
                                 ->where('triwulan', $triwulan);
                           })
                           ->get();

        return Excel::download(new class($penilaian) implements \Maatwebsite\Excel\Concerns\FromCollection {
            private $data;
            
            public function __construct($data) {
                $this->data = $data;
            }
            
            public function collection() {
                return $this->data->map(function($item) {
                    return [
                        'Nama Staff' => $item->user->name,
                        'NIP Staff' => $item->user->nip,
                        'Tugas' => $item->realisasiKinerja->task->nama_tugas ?? '-',
                        'Nama Kasi' => $item->createdBy->name,
                        'Rating' => $item->rating,
                        'Komentar' => $item->komentar,
                        'Tanggal' => $item->created_at->format('d/m/Y H:i')
                    ];
                });
            }
        }, "laporan-penilaian-kinerja-{$tahun}-triwulan-{$triwulan}.xlsx");
    }

    /**
     * Tampilkan profil Kepala
     */
    public function profil()
    {
        if (!session('kepala_logged_in')) {
            return redirect('/login/kepala');
        }

        $kepalaId = session('kepala_id');
        $kepala = User::find($kepalaId);

        return view('kepala.profil', compact('kepala'));
    }

    /**
     * Logout Kepala
     */
    public function logout()
    {
        session()->forget(['kepala_logged_in', 'kepala_name', 'kepala_id']);
        Auth::logout();
        
        return redirect('/login/kepala')
                       ->with('success', 'Anda berhasil logout.');
    }

    /**
     * Tampilkan halaman penilaian Kasi
     */
    public function penilaianKasi(Request $request)
    {
        if (!session('kepala_logged_in')) {
            return redirect('/login/kepala');
        }

        $tahun = $request->get('tahun', date('Y'));
        $triwulan = $request->get('triwulan', $this->getCurrentQuarter());

        // Ambil semua Kasi
        $kasiList = User::where('role', 'kasi')->get();

        // Ambil penilaian yang sudah ada untuk periode ini
        $penilaianExisting = PenilaianKepala::periode($tahun, $triwulan)
                                           ->with('kasi')
                                           ->get()
                                           ->keyBy('kasi_id');

        // Statistik penilaian Kasi
        $statistikKasi = [];
        foreach ($kasiList as $kasi) {
            $totalStaff = $kasi->staffs()->count();
            $totalPenilaianStaff = Comment::whereIn('user_id', $kasi->staffs()->pluck('id'))
                                         ->whereHas('realisasiKinerja', function($q) use ($tahun, $triwulan) {
                                             $q->where('tahun', $tahun)
                                               ->where('triwulan', $triwulan);
                                         })
                                         ->count();
            
            $rataRataStaff = Comment::whereIn('user_id', $kasi->staffs()->pluck('id'))
                                   ->whereHas('realisasiKinerja', function($q) use ($tahun, $triwulan) {
                                       $q->where('tahun', $tahun)
                                         ->where('triwulan', $triwulan);
                                   })
                                   ->avg('rating');

            $statistikKasi[] = [
                'kasi' => $kasi,
                'total_staff' => $totalStaff,
                'total_penilaian_staff' => $totalPenilaianStaff,
                'rata_rata_staff' => $rataRataStaff ? round($rataRataStaff, 2) : 0,
                'sudah_dinilai' => $penilaianExisting->has($kasi->id),
                'penilaian' => $penilaianExisting->get($kasi->id)
            ];
        }

        return view('kepala.penilaian-kasi', compact(
            'kasiList',
            'statistikKasi',
            'tahun',
            'triwulan'
        ));
    }

    /**
     * Simpan penilaian Kasi
     */
    public function simpanPenilaianKasi(Request $request)
    {
        if (!session('kepala_logged_in')) {
            return redirect('/login/kepala');
        }

        $request->validate([
            'kasi_id' => 'required|exists:users,id',
            'tahun' => 'required|integer',
            'triwulan' => 'required|string',
            'rating' => 'required|integer|in:1,2,3',
            'komentar' => 'required|string|max:1000'
        ]);

        // Validasi bahwa user yang dinilai adalah Kasi
        $kasi = User::find($request->kasi_id);
        if (!$kasi || $kasi->role !== 'kasi') {
            return back()->withErrors(['kasi_id' => 'User yang dipilih bukan Kasi.']);
        }

        $kepalaId = session('kepala_id');

        // Update atau create penilaian
        $penilaian = PenilaianKepala::updateOrCreate(
            [
                'kasi_id' => $request->kasi_id,
                'tahun' => $request->tahun,
                'triwulan' => $request->triwulan
            ],
            [
                'rating' => $request->rating,
                'komentar' => $request->komentar,
                'created_by' => $kepalaId
            ]
        );

        return redirect()->route('kepala.penilaian-kasi')
                        ->with('success', 'Penilaian Kasi berhasil disimpan!');
    }

    /**
     * Get current quarter
     */
    private function getCurrentQuarter()
    {
        $month = date('n');
        if ($month <= 3) return 'I';
        if ($month <= 6) return 'II';
        if ($month <= 9) return 'III';
        return 'IV';
    }
} 