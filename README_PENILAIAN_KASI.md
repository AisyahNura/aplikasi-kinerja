# Fitur Penilaian Kepala untuk Kasi

## Deskripsi
Fitur ini memungkinkan Kepala Kantor untuk memberikan penilaian langsung kepada Kasi (Kepala Seksi) berdasarkan kinerja mereka dalam mengelola staff dan melaksanakan tugas.

## Komponen yang Diimplementasikan

### 1. Database
- **Tabel**: `penilaian_kepala`
- **Kolom**:
  - `id` (primary key)
  - `kasi_id` (foreign key ke users)
  - `tahun` (integer)
  - `triwulan` (string: I, II, III, IV)
  - `rating` (integer: 1-3)
  - `komentar` (text)
  - `created_by` (foreign key ke users - ID Kepala)
  - `timestamps`

### 2. Model
- **File**: `app/Models/PenilaianKepala.php`
- **Fitur**:
  - Relasi `kasi()` dan `kepala()`
  - Scope `periode()` dan `kasi()`
  - Helper `rating_label` dan `rating_color`
  - Constraint unique pada `kasi_id`, `tahun`, `triwulan`

### 3. Controller
- **File**: `app/Http/Controllers/KepalaController.php`
- **Method**:
  - `penilaianKasi()`: Menampilkan halaman penilaian Kasi
  - `simpanPenilaianKasi()`: Menyimpan/update penilaian Kasi

### 4. Routes
```php
GET  /kepala/penilaian-kasi
POST /kepala/penilaian-kasi/simpan
```

### 5. View
- **File**: `resources/views/kepala/penilaian-kasi.blade.php`
- **Fitur**:
  - Filter tahun dan triwulan
  - Daftar Kasi dengan statistik (total staff, total penilaian staff, rata-rata rating staff)
  - Form penilaian dengan rating 1-3 dan komentar
  - Modal untuk edit penilaian yang sudah ada
  - Status "Sudah Dinilai" / "Belum Dinilai"

### 6. Sidebar Menu
- **File**: `resources/views/layouts/kepala.blade.php`
- **Menu**: "Penilaian Kasi" dengan icon dan route yang sesuai

## Sistem Rating
- **1 Bintang**: Di Bawah Ekspektasi (Merah)
- **2 Bintang**: Sesuai Ekspektasi (Kuning)
- **3 Bintang**: Melebihi Ekspektasi (Hijau)

## Statistik yang Ditampilkan
Untuk setiap Kasi, sistem menampilkan:
1. **Total Staff**: Jumlah staff yang berada di bawah Kasi tersebut
2. **Total Penilaian Staff**: Jumlah penilaian yang telah diberikan Kasi kepada staff-nya
3. **Rata-rata Rating Staff**: Rata-rata rating yang diberikan Kasi kepada staff-nya

## Validasi
- Satu Kasi hanya bisa dinilai sekali per periode (tahun + triwulan)
- Rating harus antara 1-3
- Komentar wajib diisi
- Hanya Kepala Kantor yang bisa memberikan penilaian

## Testing
Untuk testing fitur ini:
1. Akses `/kepala/demo` untuk login sebagai Kepala Kantor
2. Klik menu "Penilaian Kasi" di sidebar
3. Pilih tahun dan triwulan
4. Berikan penilaian kepada Kasi yang belum dinilai
5. Edit penilaian yang sudah ada melalui modal

## Data Sample
Saat ini sudah ada 2 data sample penilaian:
- Kasi 1 (ID: 2): Rating 3 - "Kinerja sangat baik dalam mengelola staff"
- Kasi 2 (ID: 3): Rating 2 - "Kinerja sesuai ekspektasi"

## Integrasi dengan Fitur Lain
- Terintegrasi dengan sistem relasi Kasi-Staff
- Menggunakan data dari tabel `comments` untuk statistik penilaian staff
- Konsisten dengan sistem rating 3-level yang digunakan di seluruh aplikasi 