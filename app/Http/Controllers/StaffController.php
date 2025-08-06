<?php

namespace App\Http\Controllers;

use App\Models\RealisasiKinerja;
use App\Models\Target;
use App\Models\Task;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    /**
     * Tampilkan halaman login Staff
     */
    public function showLogin()
    {
        return view('auth.login-staff');
    }

    /**
     * Handle login Staff
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
            
            // Check if user has staff role
            if ($user->role !== 'staff') {
                Auth::logout();
                Log::warning('Staff login failed - wrong role:', ['email' => $request->email, 'role' => $user->role]);
                return back()->withErrors([
                    'email' => 'Email atau NIP salah.',
                ])->withInput($request->only('email'));
            }

            // Set session data
            session(['staff_logged_in' => true]);
            session(['staff_name' => $user->name]);
            session(['staff_id' => $user->id]);
            
            Log::info('Staff login successful:', ['user_id' => $user->id, 'email' => $user->email]);
            
            return redirect('/staff/dashboard')
                           ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        Log::warning('Staff login failed:', ['email' => $request->email]);

        return back()->withErrors([
            'email' => 'Email atau NIP salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Tampilkan dashboard Staff
     */
    public function dashboard(Request $request)
    {
        // Cek apakah sudah login
        if (!session('staff_logged_in')) {
            return redirect('/login/staff')
                           ->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $staffId = session('staff_id');
        $currentYear = date('Y');
        $currentQuarter = $this->getCurrentQuarter();
        
        // Ambil filter dari request
        $tahun = $request->get('tahun', $currentYear);
        $triwulan = $request->get('triwulan', $currentQuarter);
        
        // Get current staff data dengan relasi kasi
        $staff = User::with('kasi')->find($staffId);
        
        if (!$staff || !$staff->isStaff()) {
            return redirect('/login/staff')
                           ->with('error', 'Akses tidak valid.');
        }
        
        // Data profil staff
        $staffName = $staff->name;
        $staffNip = $staff->nip;
        $staffPangkat = 'Penata Muda Tingkat I / III/b';
        $staffJabatan = $staff->jabatan;
        $staffUnitKerja = 'Kantor Kementerian Agama Kabupaten Jombang';
        
        // Data atasan yang menilai (kasi)
        $atasan = $staff->kasi;
        $atasanName = $atasan ? $atasan->name : 'Belum Ada Atasan';
        $atasanNip = $atasan ? $atasan->nip : '-';
        $atasanPangkat = 'Penata Tk.I / III/d';
        $atasanJabatan = $atasan ? $atasan->jabatan : 'Kasi';
        $atasanUnitKerja = 'Kantor Kementerian Agama Kabupaten Jombang';
        
        // Statistik kinerja
        $totalTarget = Target::where('user_id', $staffId)
                           ->where('tahun', $currentYear)
                           ->where('triwulan', $currentQuarter)
                           ->count();
        
        $draftCount = RealisasiKinerja::where('user_id', $staffId)
                                     ->where('status', 'draft')
                                     ->count();
        
        $menungguCount = RealisasiKinerja::where('user_id', $staffId)
                                        ->where('status', 'dikirim')
                                        ->count();
        
        $sudahDinilaiCount = RealisasiKinerja::where('user_id', $staffId)
                                            ->where('status', 'verif')
                                            ->count();
        
        // Ambil komentar berdasarkan filter
        $filteredComments = Comment::with(['realisasiKinerja.task', 'createdBy'])
                                  ->where('user_id', $staffId)
                                  ->whereHas('realisasiKinerja', function($query) use ($tahun, $triwulan) {
                                      $query->where('tahun', $tahun)
                                            ->where('triwulan', $triwulan);
                                  })
                                  ->orderBy('created_at', 'desc')
                                  ->get();
        
        return view('staff.dashboard', compact(
            'staffName',
            'staffNip',
            'staffPangkat',
            'staffJabatan',
            'staffUnitKerja',
            'atasanName',
            'atasanNip',
            'atasanPangkat',
            'atasanJabatan',
            'atasanUnitKerja',
            'totalTarget',
            'draftCount',
            'menungguCount',
            'sudahDinilaiCount',
            'filteredComments',
            'currentQuarter',
            'currentYear',
            'tahun',
            'triwulan'
        ));
    }

    /**
     * Tampilkan halaman kinerja saya
     */
    public function kinerjaSaya(Request $request)
    {
        // Cek apakah sudah login
        if (!session('staff_logged_in')) {
            return redirect('/login/staff')
                           ->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $staffId = session('staff_id');
        $tahun = $request->get('tahun', date('Y'));
        $triwulan = $request->get('triwulan', $this->getCurrentQuarter());
        
        // Ambil target dari Kasi
        $targets = Target::with('task')
                        ->where('user_id', $staffId)
                        ->where('tahun', $tahun)
                        ->where('triwulan', $triwulan)
                        ->where('status', 'aktif')
                        ->get();
        
        // Ambil realisasi kinerja dengan comments
        $realisasiKinerja = RealisasiKinerja::with(['comments' => function($query) {
                                            $query->orderBy('created_at', 'desc');
                                        }])
                                           ->where('user_id', $staffId)
                                           ->where('tahun', $tahun)
                                           ->where('triwulan', $triwulan)
                                           ->get()
                                           ->keyBy('tugas_id');
        
        return view('staff.kinerja-saya', compact('targets', 'realisasiKinerja', 'tahun', 'triwulan'));
    }

    /**
     * Simpan realisasi kinerja
     */
    public function simpanRealisasi(Request $request)
    {
        $request->validate([
            'tugas_id' => 'required|integer',
            'realisasi_kuantitas' => 'required|integer|min:0',
            'realisasi_waktu' => 'required|integer|min:0',
            'kualitas' => 'required|integer|min:1|max:100',
            'link_bukti' => 'nullable|url|starts_with:https://',
        ], [
            'link_bukti.starts_with' => 'Link bukti harus dimulai dengan https://',
        ]);

        $staffId = session('staff_id');
        
        // Cek apakah sudah ada realisasi untuk tugas ini
        $realisasi = RealisasiKinerja::where('user_id', $staffId)
                                    ->where('tugas_id', $request->tugas_id)
                                    ->where('tahun', $request->tahun)
                                    ->where('triwulan', $request->triwulan)
                                    ->first();
        
        if ($realisasi) {
            // Update existing
            $realisasi->update([
                'realisasi_kuantitas' => $request->realisasi_kuantitas,
                'realisasi_waktu' => $request->realisasi_waktu,
                'kualitas' => $request->kualitas,
                'link_bukti' => $request->link_bukti,
                'status' => 'draft',
            ]);
        } else {
            // Create new
            $target = Target::where('user_id', $staffId)
                           ->where('tugas_id', $request->tugas_id)
                           ->where('tahun', $request->tahun)
                           ->where('triwulan', $request->triwulan)
                           ->first();
            
            if (!$target) {
                return back()->with('error', 'Target tidak ditemukan.');
            }
            
            RealisasiKinerja::create([
                'user_id' => $staffId,
                'tugas_id' => $request->tugas_id,
                'tahun' => $request->tahun,
                'triwulan' => $request->triwulan,
                'target_kuantitas' => $target->target_kuantitas,
                'realisasi_kuantitas' => $request->realisasi_kuantitas,
                'target_waktu' => $target->target_waktu,
                'realisasi_waktu' => $request->realisasi_waktu,
                'kualitas' => $request->kualitas,
                'link_bukti' => $request->link_bukti,
                'status' => 'draft',
            ]);
        }
        
        return back()->with('success', 'Realisasi kinerja berhasil disimpan.');
    }

    /**
     * Kirim realisasi kinerja
     */
    public function kirimRealisasi(Request $request)
    {
        $staffId = session('staff_id');
        $tahun = $request->tahun;
        $triwulan = $request->triwulan;
        
        // Update status semua realisasi dari draft menjadi dikirim
        $updated = RealisasiKinerja::where('user_id', $staffId)
                                  ->where('tahun', $tahun)
                                  ->where('triwulan', $triwulan)
                                  ->where('status', 'draft')
                                  ->update(['status' => 'dikirim']);
        
        if ($updated > 0) {
            return back()->with('success', 'Realisasi kinerja berhasil dikirim ke Kasi.');
        } else {
            return back()->with('error', 'Tidak ada realisasi yang dapat dikirim.');
        }
    }



    /**
     * Tampilkan halaman komentar
     */
    public function komentar()
    {
        // Cek apakah sudah login
        if (!session('staff_logged_in')) {
            return redirect('/login/staff')
                           ->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $staffId = session('staff_id');
        
        // Ambil komentar
        $comments = Comment::with(['realisasiKinerja.task', 'createdBy'])
                          ->where('user_id', $staffId)
                          ->orderBy('created_at', 'desc')
                          ->get();
        
        // Tandai semua komentar sebagai sudah dibaca
        Comment::where('user_id', $staffId)
               ->where('is_read', false)
               ->update(['is_read' => true]);
        
        return view('staff.komentar', compact('comments'));
    }

    /**
     * Tandai komentar sebagai sudah dibaca
     */
    public function markCommentAsRead(Request $request)
    {
        // Cek apakah sudah login
        if (!session('staff_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $staffId = session('staff_id');
        $commentId = $request->comment_id;
        
        $comment = Comment::where('id', $commentId)
                         ->where('user_id', $staffId)
                         ->first();
        
        if ($comment) {
            $comment->update(['is_read' => true]);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Comment not found'], 404);
    }

    /**
     * Tandai semua komentar sebagai sudah dibaca
     */
    public function markAllCommentsAsRead()
    {
        // Cek apakah sudah login
        if (!session('staff_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $staffId = session('staff_id');
        
        Comment::where('user_id', $staffId)
               ->where('is_read', false)
               ->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }







    /**
     * Tampilkan profil Staff
     */
    public function profil()
    {
        // Cek apakah sudah login
        if (!session('staff_logged_in')) {
            return redirect('/login/staff')
                           ->with('error', 'Silakan login terlebih dahulu.');
        }
        
        return view('staff.profil');
    }

    /**
     * Logout Staff
     */
    public function logout()
    {
        Auth::logout();
        session()->forget(['staff_logged_in', 'staff_name', 'staff_id']);
        
        return redirect('/login/staff')
                       ->with('success', 'Anda telah berhasil logout.');
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