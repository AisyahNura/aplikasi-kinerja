<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RealisasiKinerjaController;
use App\Http\Controllers\KasiController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\KepalaController;

/**
 * WEB ROUTES - File routing utama aplikasi kinerja
 * 
 * FLOW SISTEM ROUTING:
 * 1. Welcome Page -> Halaman utama aplikasi
 * 2. Authentication Routes -> Login untuk setiap role (Staff, KASI, Kepala)
 * 3. Role-based Routes -> Setiap role memiliki prefix dan middleware sendiri
 * 4. Realisasi Kinerja Routes -> Fitur input kinerja staff
 * 5. Logout Routes -> Hapus session dan redirect
 * 
 * STRUKTUR ROUTING:
 * - / -> Welcome page
 * - /login/{role} -> Login form untuk role tertentu
 * - /{role}/dashboard -> Dashboard untuk role tertentu
 * - /{role}/penilaian -> Fitur penilaian kinerja
 * - /{role}/profil -> Profil user
 * - /{role}/logout -> Logout untuk role tertentu
 */

// Route utama aplikasi
Route::get('/', function () {
    return view('welcome');
});

// Route untuk halaman staff.blade.php yang sudah ada (dengan proteksi login)
Route::get('/staff', function () {
    // Cek apakah sudah login
    if (!session('staff_logged_in')) {
        return redirect('/login/staff')
                       ->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('staff');
});

// Route untuk halaman test (tanpa auth)
Route::get('/test', function () {
    return 'Aplikasi berjalan dengan baik!';
});

// AUTHENTICATION ROUTES
// FLOW: User mengakses halaman login sesuai rolenya
Route::get('/login/kepala', [KepalaController::class, 'showLogin']);
Route::get('/login/kasi', [KasiController::class, 'showLogin']);
Route::get('/login/staff', [StaffController::class, 'showLogin']);

// Route untuk proses login setiap role
// FLOW: Form login -> Validasi -> Set session -> Redirect ke dashboard
Route::post('/kasi/login', [KasiController::class, 'login'])->name('kasi.login');
Route::post('/staff/login', [StaffController::class, 'login'])->name('staff.login');
Route::post('/kepala/login', [KepalaController::class, 'login'])->name('kepala.login');

// General logout route
// FLOW: Hapus auth -> Hapus session -> Redirect ke home
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// REALISASI KINERJA ROUTES
// FLOW: Staff input kinerja -> Simpan draft -> Kirim ke KASI
Route::middleware(['web'])->group(function () {
    Route::get('/realisasi-kinerja', [RealisasiKinerjaController::class, 'index'])->name('realisasi-kinerja.index');
    Route::get('/realisasi-kinerja/create', [RealisasiKinerjaController::class, 'create'])->name('realisasi-kinerja.create');
    Route::post('/realisasi-kinerja', [RealisasiKinerjaController::class, 'store'])->name('realisasi-kinerja.store');
    Route::post('/realisasi-kinerja/draft', [RealisasiKinerjaController::class, 'storeDraft'])->name('realisasi-kinerja.store-draft');
});

// KASI ROUTES
// FLOW: KASI login -> Dashboard -> Kelola staff -> Penilaian kinerja
Route::prefix('kasi')->name('kasi.')->group(function () {
    Route::get('/dashboard', [KasiController::class, 'dashboard'])->name('dashboard');
    Route::get('/daftar-staff', [KasiController::class, 'daftarStaff'])->name('daftar-staff');
    Route::get('/tugas/{id}/detail', [KasiController::class, 'detailTugas'])->name('tugas.detail');
    Route::get('/penilaian', [KasiController::class, 'penilaian'])->name('penilaian');
    Route::get('/penilaian/riwayat', [KasiController::class, 'riwayatPenilaian'])->name('penilaian.riwayat');
    Route::post('/penilaian/simpan', [KasiController::class, 'simpanPenilaian'])->name('penilaian.simpan');
    Route::get('/profil', [KasiController::class, 'profil'])->name('profil');
    Route::get('/logout', [KasiController::class, 'logout'])->name('logout');
});

// STAFF ROUTES
// FLOW: Staff login -> Dashboard -> Input kinerja -> Lihat komentar
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/kinerja-saya', [StaffController::class, 'kinerjaSaya'])->name('kinerja-saya');
    Route::post('/simpan-realisasi', [StaffController::class, 'simpanRealisasi'])->name('simpan-realisasi');
    Route::post('/kirim-realisasi', [StaffController::class, 'kirimRealisasi'])->name('kirim-realisasi');
    Route::get('/komentar', [StaffController::class, 'komentar'])->name('komentar');
    Route::post('/komentar/mark-read', [StaffController::class, 'markCommentAsRead'])->name('komentar.mark-read');
    Route::post('/komentar/mark-all-read', [StaffController::class, 'markAllCommentsAsRead'])->name('komentar.mark-all-read');
    Route::get('/profil', [StaffController::class, 'profil'])->name('profil');
    Route::get('/logout', [StaffController::class, 'logout'])->name('logout');
});

// KEPALA ROUTES
// FLOW: Kepala login -> Dashboard -> Lihat struktur -> Penilaian KASI
Route::prefix('kepala')->name('kepala.')->middleware(['web'])->group(function () {
    Route::get('/dashboard', [KepalaController::class, 'dashboard'])->name('dashboard');
    Route::get('/data-pegawai', [KepalaController::class, 'dataPegawai'])->name('data-pegawai');
    Route::get('/struktur-organisasi', [KepalaController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
    
    Route::get('/penilaian-kasi', [KepalaController::class, 'penilaianKasi'])->name('penilaian-kasi');
    Route::post('/penilaian-kasi/simpan', [KepalaController::class, 'simpanPenilaianKasi'])->name('penilaian-kasi.simpan');
    
    Route::get('/export/pdf', [KepalaController::class, 'exportPDF'])->name('export.pdf');
    Route::get('/export/excel', [KepalaController::class, 'exportExcel'])->name('export.excel');
    Route::get('/profil', [KepalaController::class, 'profil'])->name('profil');
    Route::get('/logout', [KepalaController::class, 'logout'])->name('logout');
});

// Routes dengan auth (untuk nanti)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/realisasi-kinerja', [RealisasiKinerjaController::class, 'index'])->name('realisasi-kinerja.index');
//     Route::get('/realisasi-kinerja/create', [RealisasiKinerjaController::class, 'create'])->name('realisasi-kinerja.create');
//     Route::post('/realisasi-kinerja', [RealisasiKinerjaController::class, 'store'])->name('realisasi-kinerja.store');
//     Route::post('/realisasi-kinerja/draft', [RealisasiKinerjaController::class, 'storeDraft'])->name('realisasi-kinerja.store-draft');
// });