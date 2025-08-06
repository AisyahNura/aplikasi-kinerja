<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Target;
use App\Models\Comment;
use App\Models\RealisasiKinerja;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call UsersTableSeeder first to create users
        $this->call([
            UsersTableSeeder::class,
        ]);

        // Create sample tasks
        $tasks = [
            [
                'nama_tugas' => 'Menyusun Laporan Bulanan',
                'deskripsi' => 'Menyusun laporan kinerja bulanan untuk diserahkan ke atasan',
                'kategori' => 'Administrasi',
                'status' => 'aktif'
            ],
            [
                'nama_tugas' => 'Membuat Presentasi Kinerja',
                'deskripsi' => 'Membuat presentasi kinerja untuk rapat evaluasi',
                'kategori' => 'Presentasi',
                'status' => 'aktif'
            ],
            [
                'nama_tugas' => 'Mengelola Dokumen Proyek',
                'deskripsi' => 'Mengelola dan mengorganisir dokumen proyek yang sedang berjalan',
                'kategori' => 'Manajemen',
                'status' => 'aktif'
            ],
            [
                'nama_tugas' => 'Koordinasi dengan Tim',
                'deskripsi' => 'Melakukan koordinasi dengan tim untuk memastikan kelancaran proyek',
                'kategori' => 'Koordinasi',
                'status' => 'aktif'
            ],
            [
                'nama_tugas' => 'Analisis Data Kinerja',
                'deskripsi' => 'Melakukan analisis data kinerja untuk evaluasi dan perbaikan',
                'kategori' => 'Analisis',
                'status' => 'aktif'
            ]
        ];

        foreach ($tasks as $taskData) {
            Task::create($taskData);
        }

        // Create sample targets for staff (user_id = 1)
        $currentYear = date('Y');
        $currentQuarter = $this->getCurrentQuarter();
        
        $targets = [
            [
                'user_id' => 1,
                'tugas_id' => 1,
                'tahun' => $currentYear,
                'triwulan' => $currentQuarter,
                'target_kuantitas' => 12,
                'target_waktu' => 30,
                'deskripsi_tugas' => 'Menyusun laporan kinerja bulanan untuk diserahkan ke atasan',
                'status' => 'aktif'
            ],
            [
                'user_id' => 1,
                'tugas_id' => 2,
                'tahun' => $currentYear,
                'triwulan' => $currentQuarter,
                'target_kuantitas' => 4,
                'target_waktu' => 15,
                'deskripsi_tugas' => 'Membuat presentasi kinerja untuk rapat evaluasi',
                'status' => 'aktif'
            ],
            [
                'user_id' => 1,
                'tugas_id' => 3,
                'tahun' => $currentYear,
                'triwulan' => $currentQuarter,
                'target_kuantitas' => 8,
                'target_waktu' => 45,
                'deskripsi_tugas' => 'Mengelola dan mengorganisir dokumen proyek yang sedang berjalan',
                'status' => 'aktif'
            ]
        ];

        foreach ($targets as $targetData) {
            Target::create($targetData);
        }

        // Create sample realisasi kinerja
        $realisasi = [
            [
                'user_id' => 1,
                'tugas_id' => 1,
                'tahun' => $currentYear,
                'triwulan' => $currentQuarter,
                'target_kuantitas' => 12,
                'realisasi_kuantitas' => 10,
                'target_waktu' => 30,
                'realisasi_waktu' => 28,
                'kualitas' => 85,
                'link_bukti' => 'https://drive.google.com/file/d/example1',
                'status' => 'draft'
            ],
            [
                'user_id' => 1,
                'tugas_id' => 2,
                'tahun' => $currentYear,
                'triwulan' => $currentQuarter,
                'target_kuantitas' => 4,
                'realisasi_kuantitas' => 4,
                'target_waktu' => 15,
                'realisasi_waktu' => 12,
                'kualitas' => 90,
                'link_bukti' => 'https://drive.google.com/file/d/example2',
                'status' => 'dikirim'
            ]
        ];

        foreach ($realisasi as $realisasiData) {
            RealisasiKinerja::create($realisasiData);
        }
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
