<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RealisasiKinerjaController;
use App\Http\Controllers\KasiController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\KepalaController;

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






Route::get('/login/kepala', [KepalaController::class, 'showLogin']);

Route::get('/login/kasi', [KasiController::class, 'showLogin']);

Route::get('/login/staff', [StaffController::class, 'showLogin']);

// Route untuk login KASI
Route::post('/kasi/login', [KasiController::class, 'login'])->name('kasi.login');

// Route untuk login STAFF
Route::post('/staff/login', [StaffController::class, 'login'])->name('staff.login');

// Route untuk login KASI
Route::post('/kasi/login', [KasiController::class, 'login'])->name('kasi.login');

// Route untuk login KEPALA
Route::post('/kepala/login', [KepalaController::class, 'login'])->name('kepala.login');

// General logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Route test tanpa auth
Route::get('/test', function () {
    return 'Aplikasi berjalan dengan baik!';
});

// Routes untuk Realisasi Kinerja (dengan database)
Route::middleware(['web'])->group(function () {
    Route::get('/realisasi-kinerja', [RealisasiKinerjaController::class, 'index'])->name('realisasi-kinerja.index');
    Route::get('/realisasi-kinerja/create', [RealisasiKinerjaController::class, 'create'])->name('realisasi-kinerja.create');
    Route::post('/realisasi-kinerja', [RealisasiKinerjaController::class, 'store'])->name('realisasi-kinerja.store');
    Route::post('/realisasi-kinerja/draft', [RealisasiKinerjaController::class, 'storeDraft'])->name('realisasi-kinerja.store-draft');
});

// Routes untuk KASI (dengan database)
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

// Routes untuk STAFF (dengan database)
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

// Routes untuk KEPALA (dengan database)
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

// Routes untuk KEPALA (dengan database) - REMOVED DUPLICATE
// Route::prefix('kepala')->name('kepala.')->group(function () {
//     Route::get('/dashboard', [KepalaController::class, 'dashboard'])->name('dashboard');
//     Route::get('/logout', [KepalaController::class, 'logout'])->name('logout');
// });

// Routes dengan auth (untuk nanti)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/realisasi-kinerja', [RealisasiKinerjaController::class, 'index'])->name('realisasi-kinerja.index');
//     Route::get('/realisasi-kinerja/create', [RealisasiKinerjaController::class, 'create'])->name('realisasi-kinerja.create');
//     Route::post('/realisasi-kinerja', [RealisasiKinerjaController::class, 'store'])->name('realisasi-kinerja.store');
//     Route::post('/realisasi-kinerja/draft', [RealisasiKinerjaController::class, 'storeDraft'])->name('realisasi-kinerja.store-draft');
// });