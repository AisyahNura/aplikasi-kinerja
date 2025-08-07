# Aplikasi Kinerja - Sistem Penilaian Kinerja Pegawai

Aplikasi web untuk mengelola dan menilai kinerja pegawai dengan sistem hierarki Kepala Kantor → Kasi → Staff.

## Teknologi yang Digunakan

- **Backend**: Laravel 12.x
- **Frontend**: Blade Templates, Tailwind CSS
- **Database**: MySQL
- **JavaScript**: Vanilla JS (ES6+)

## Fitur yang Tersedia

### Staff
- Dashboard dengan statistik kinerja
- Input realisasi kinerja
- Melihat komentar dari atasan dengan sistem rating 3-level
- Profil staff dan atasan

### Kasi (Kepala Seksi)
- Dashboard dengan statistik staff
- Penilaian kinerja staff dengan sistem rating 3-level
- Monitoring realisasi kinerja staff
- Profil Kasi dan staff yang dibawahi

### Kepala Kantor
- Dashboard dengan statistik umum
- Data pegawai (Kasi dan Staff)
- Monitoring penilaian kinerja
- **Penilaian Kasi** - Memberikan penilaian langsung kepada Kasi
- Komentar umum untuk periode tertentu
- Export laporan (PDF/Excel)
- Profil Kepala Kantor

## Sistem Rating

Aplikasi menggunakan sistem rating 3-level:
- **1 Bintang**: Di Bawah Ekspektasi (Merah)
- **2 Bintang**: Sesuai Ekspektasi (Kuning)  
- **3 Bintang**: Melebihi Ekspektasi (Hijau)

## Struktur Database

### Tabel Utama
- `users` - Data pegawai (Kepala, Kasi, Staff)
- `tasks` - Daftar tugas
- `targets` - Target kinerja per staff
- `realisasi_kinerja` - Realisasi kinerja staff
- `comments` - Komentar/penilaian dari Kasi ke Staff
- `komentar_kepala` - Komentar umum dari Kepala Kantor
- `penilaian_kepala` - Penilaian Kepala Kantor ke Kasi

### Relasi
- Kepala Kantor → Kasi (melalui penilaian_kepala)
- Kasi → Staff (melalui kasi_id di users)
- Kasi → Staff (melalui comments)

## Instalasi

1. Clone repository
```bash
git clone <repository-url>
cd aplikasi-kinerja
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di `.env`

5. Jalankan migration dan seeder
```bash
php artisan migrate:fresh --seed
```

6. Jalankan server
```bash
php artisan serve
```

## Data Sample

Setelah menjalankan seeder, aplikasi akan memiliki data sample:

### Users
- **Kepala Kantor**: kepala.kantor@kemenag.go.id (password: 12345678)
- **Kasi 1**: kasi.pendma@kemenag.go.id (password: 12345678)
- **Kasi 2**: kasi.haji@kemenag.go.id (password: 12345678)
- **Staff**: 3 staff dengan relasi ke Kasi

### Demo Login
- Staff: `/staff/demo`
- Kasi: `/kasi/demo`
- Kepala: `/kepala/demo`

## Dokumentasi Fitur

- [Fitur Komentar Staff](README_KOMENTAR_FEATURE.md)
- [Fitur Penilaian Kasi](README_PENILAIAN_KASI.md)

## Struktur File Penting

### Controllers
- `StaffController.php` - Logic untuk Staff
- `KasiController.php` - Logic untuk Kasi
- `KepalaController.php` - Logic untuk Kepala Kantor

### Models
- `User.php` - Model user dengan relasi Kasi-Staff
- `Comment.php` - Model komentar/penilaian
- `PenilaianKepala.php` - Model penilaian Kepala ke Kasi
- `RealisasiKinerja.php` - Model realisasi kinerja

### Views
- `staff/` - Views untuk Staff
- `kasi/` - Views untuk Kasi
- `kepala/` - Views untuk Kepala Kantor
- `layouts/` - Layout templates

## Testing

Untuk testing fitur:
1. Akses demo login sesuai role
2. Navigasi melalui menu sidebar
3. Test fitur penilaian dan komentar
4. Verifikasi relasi Kasi-Staff

## License

MIT License
