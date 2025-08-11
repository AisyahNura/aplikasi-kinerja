# 🚀 OVERVIEW PROYEK APLIKASI KINERJA

## 📋 INFORMASI DASAR
- **Framework**: Laravel 10.x
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS
- **Database**: MySQL
- **Pattern**: MVC (Model-View-Controller)

---

## 🎯 ENTRY POINT PENTING

### 1. ROUTES (URL Mapping)
```
routes/web.php ← File utama routing
├── /kasi/penilaian → KasiController@penilaian
├── /kasi/penilaian/simpan → KasiController@simpanPenilaian
└── /kasi/daftar-staff → KasiController@daftarStaff
```

### 2. CONTROLLERS (Logic Bisnis)
```
app/Http/Controllers/
├── KasiController.php ← Mengatur semua fitur KASI
├── StaffController.php ← Mengatur semua fitur Staff
├── KepalaController.php ← Mengatur semua fitur Kepala
└── RealisasiKinerjaController.php ← Mengatur input kinerja
```

### 3. MODELS (Struktur Data)
```
app/Models/
├── User.php ← Model utama user (staff/kasi/kepala)
├── PenilaianStaff.php ← Data penilaian staff
├── RealisasiKinerja.php ← Data kinerja harian
├── Comment.php ← Data komentar/feedback
└── Task.php ← Data tugas yang dikerjakan
```

### 4. VIEWS (Tampilan UI)
```
resources/views/
├── layouts/ ← Template dasar
├── kasi/ ← Halaman khusus KASI
├── staff/ ← Halaman khusus Staff
├── kepala/ ← Halaman khusus Kepala
└── auth/ ← Halaman login
```

---

## 🔄 ALUR REQUEST: /kasi/penilaian → Klik "Simpan"

### Step 1: User Akses Halaman
```
Browser → /kasi/penilaian
↓
routes/web.php (line 85)
Route::get('/kasi/penilaian', [KasiController::class, 'penilaian'])
↓
KasiController::penilaian()
```

### Step 2: Controller Ambil Data
```php
// KasiController.php line 152
public function penilaian()
{
    // Ambil data staff yang dibawahi
    $staffList = $kasi->staffs()->get();
    
    // Tampilkan view dengan data
    return view('kasi.penilaian', compact('staffList'));
}
```

### Step 3: View Render HTML
```
resources/views/kasi/penilaian.blade.php
├── Form input penilaian
├── Dropdown pilih staff
├── Input nilai (1-100)
├── Textarea komentar
└── Button "Simpan"
```

### Step 4: User Klik "Simpan"
```
Form submit → POST /kasi/penilaian/simpan
↓
routes/web.php (line 86)
Route::post('/kasi/penilaian/simpan', [KasiController::class, 'simpanPenilaian'])
↓
KasiController::simpanPenilaian()
```

### Step 5: Controller Proses Data
```php
// KasiController.php line 258
public function simpanPenilaian(Request $request)
{
    // Validasi input
    $request->validate([
        'staff_id' => 'required',
        'nilai' => 'required|numeric|min:1|max:100',
        'komentar' => 'required|string'
    ]);
    
    // Simpan ke database
    PenilaianStaff::create([
        'kasi_id' => session('kasi_id'),
        'staff_id' => $request->staff_id,
        'nilai' => $request->nilai,
        'komentar' => $request->komentar
    ]);
    
    // Redirect dengan pesan sukses
    return redirect()->back()->with('success', 'Penilaian berhasil disimpan!');
}
```

### Step 6: Data Tersimpan
```
Database: tabel penilaian_staff
├── kasi_id: ID KASI yang login
├── staff_id: ID staff yang dinilai
├── nilai: Nilai 1-100
├── komentar: Feedback dari KASI
└── created_at: Waktu penilaian
```

---

## 📚 URUTAN FILE YANG HARUS DIBACA (1..N)

### 🔥 LEVEL 1 - WAJIB BACA DULU
```
1. routes/web.php ← Pahami alur URL aplikasi
2. app/Http/Controllers/KasiController.php ← Logic utama KASI
3. app/Models/User.php ← Struktur data user
4. resources/views/kasi/penilaian.blade.php ← Form penilaian
```

### ⚡ LEVEL 2 - HARUS BACA
```
5. app/Http/Controllers/StaffController.php ← Logic Staff
6. app/Http/Controllers/KepalaController.php ← Logic Kepala
7. resources/views/layouts/kasi.blade.php ← Template KASI
8. app/Models/PenilaianStaff.php ← Model penilaian
```

### 💡 LEVEL 3 - BAGUS KALAU BACA
```
9. database/migrations/2024_02_14_000001_create_penilaian_staff_table.php
10. app/Http/Middleware/RoleKepala.php ← Filter akses
11. resources/views/kasi/dashboard.blade.php ← Dashboard KASI
12. app/Providers/AppServiceProvider.php ← Konfigurasi global
```

### 🎯 LEVEL 4 - OPTIONAL
```
13. composer.json ← Dependencies PHP
14. package.json ← Dependencies JavaScript
15. vite.config.js ← Build configuration
16. .env.example ← Template environment
```

---

## 🎯 FOKUS BELAJAR PER MINGGU

### Minggu 1: Routing & Controllers
- Baca `routes/web.php` sampai paham
- Pahami `KasiController.php` method per method
- Test setiap route di browser

### Minggu 2: Models & Database
- Pelajari `User.php` dan relasinya
- Pahami struktur database dari migrations
- Test query di tinker

### Minggu 3: Views & UI
- Analisis `penilaian.blade.php`
- Pahami Blade syntax
- Modifikasi tampilan sedikit-sedikit

### Minggu 4: Integration
- Gabungkan semua yang sudah dipelajari
- Buat fitur baru sederhana
- Test end-to-end

---

## 🛠️ TIPS BELAJAR CEPAT

1. **Mulai dari yang Sederhana**: Pahami dulu routing, baru ke controller
2. **Gunakan Debug**: Tambahkan `dd()` di controller untuk lihat data
3. **Test Langsung**: Jalankan aplikasi dan test setiap fitur
4. **Buat Diagram**: Gambar flow aplikasi di kertas
5. **Tanya-tanya**: Jangan malu bertanya jika tidak paham

---

## 📁 STRUKTUR FILE LENGKAP

### File Konfigurasi & Setup
```
composer.json          ← Daftar package/library yang dibutuhkan
package.json           ← Daftar package JavaScript/Node.js
.env                   ← Konfigurasi database, email, dll
artisan                ← Command line tool Laravel
```

### Folder app/ - Inti Aplikasi
```
app/Http/Controllers/     ← Logic bisnis
├── Controller.php        ← Controller dasar (parent class)
├── KasiController.php    ← Mengatur semua fitur KASI
├── StaffController.php   ← Mengatur semua fitur Staff  
├── KepalaController.php  ← Mengatur semua fitur Kepala
└── RealisasiKinerjaController.php ← Mengatur input kinerja staff

app/Models/              ← Struktur Data
├── User.php             ← Model untuk semua user
├── RealisasiKinerja.php ← Model untuk data kinerja staff
├── Task.php             ← Model untuk tugas yang dikerjakan
├── Target.php           ← Model untuk target kinerja
├── Comment.php          ← Model untuk komentar/feedback
├── PenilaianStaff.php   ← Model untuk penilaian staff oleh KASI
├── PenilaianKepala.php  ← Model untuk penilaian KASI oleh Kepala
└── KomentarKepala.php   ← Model untuk komentar kepala

app/Providers/           ← Service Provider
└── AppServiceProvider.php ← Konfigurasi global aplikasi
```

### Folder database/ - Pengelolaan Data
```
database/migrations/     ← Struktur Database
├── 0001_01_01_000000_create_users_table.php
├── 2024_02_14_000001_create_penilaian_staff_table.php
├── 2025_07_28_014628_create_realisasi_kinerja_table.php
├── 2025_07_30_020433_create_tasks_table.php
├── 2025_07_30_020457_create_targets_table.php
├── 2025_07_30_020501_create_comments_table.php
├── 2025_08_01_011035_add_rating_to_comments_table.php
├── 2025_08_06_021549_create_komentar_kepala_table.php
├── 2025_08_06_025049_add_kasi_id_to_users_table.php
└── 2025_08_06_063645_create_penilaian_kepala_table.php

database/seeders/       ← Data Awal
├── DatabaseSeeder.php  ← Seeder utama
├── UserSeeder.php      ← Data user untuk testing
├── UsersTableSeeder.php ← Data user tambahan
├── RealisasiKinerjaSeeder.php ← Data kinerja untuk testing
└── CommentSeeder.php   ← Data komentar untuk testing
```

### Folder resources/views/ - Tampilan UI
```
resources/views/layouts/ ← Template Dasar
├── app.blade.php        ← Layout utama aplikasi
├── kasi.blade.php       ← Layout khusus untuk KASI
├── kepala.blade.php     ← Layout khusus untuk Kepala
└── staff.blade.php      ← Layout khusus untuk Staff

resources/views/auth/    ← Halaman Login
├── login-role.blade.php ← Pilihan role login
├── login-kasi.blade.php ← Form login KASI
├── login-kepala.blade.php ← Form login Kepala
└── login-staff.blade.php ← Form login Staff

resources/views/kasi/    ← Halaman KASI
├── dashboard.blade.php  ← Dashboard utama KASI
├── daftar-staff.blade.php ← Daftar staff yang dibawahi
├── penilaian.blade.php  ← Form penilaian staff
├── detail-tugas.blade.php ← Detail tugas staff
└── profil.blade.php     ← Profil KASI

resources/views/kepala/  ← Halaman Kepala
├── dashboard.blade.php  ← Dashboard utama Kepala
├── data-pegawai.blade.php ← Data semua pegawai
├── penilaian-kasi.blade.php ← Form penilaian KASI
├── penilaian.blade.php  ← Penilaian umum
├── struktur-organisasi.blade.php ← Struktur organisasi
└── profil.blade.php     ← Profil Kepala

resources/views/staff/   ← Halaman Staff
├── dashboard.blade.php  ← Dashboard utama Staff
├── kinerja-saya.blade.php ← Input kinerja harian
├── komentar.blade.php   ← Lihat komentar KASI
└── profil.blade.php     ← Profil Staff

resources/views/realisasi-kinerja/ ← Fitur Kinerja
├── index.blade.php      ← Daftar kinerja
└── create.blade.php     ← Form input kinerja
```

### Folder routes/ - Pengaturan URL
```
routes/
├── web.php              ← Semua route aplikasi
└── console.php          ← Route untuk command line
```

### Folder public/ - File Publik
```
public/
├── index.php            ← Entry point aplikasi
├── js/                  ← File JavaScript
│   └── staff.js        ← JavaScript khusus staff
├── css/                 ← File CSS
├── logo_kemenag.png     ← Logo aplikasi
└── favicon.ico          ← Icon browser
```

### File Dokumentasi
```
README.md                ← Dokumentasi utama aplikasi
├── README_STAFF_FEATURES.md ← Dokumentasi fitur staff
├── README_PENILAIAN_KASI.md ← Dokumentasi sistem penilaian
└── README_KOMENTAR_FEATURE.md ← Dokumentasi fitur komentar
```

---

## 🔑 KUNCI SUKSES BELAJAR

1. **Jangan Terburu-buru**: Pahami satu fitur sampai benar-benar paham
2. **Praktik Langsung**: Jangan hanya baca, tapi coba jalankan
3. **Buat Catatan**: Tulis poin-poin penting di buku catatan
4. **Test Setiap Perubahan**: Pastikan fitur tetap berjalan setelah dimodifikasi
5. **Gunakan Version Control**: Commit setiap perubahan penting ke Git

---

**Selamat Belajar! 🎉**
**Jangan lupa: Coding adalah skill yang butuh waktu dan latihan!**
