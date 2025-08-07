<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Models\Target;
use App\Models\RealisasiKinerja;
use App\Models\Comment;

class RealisasiKinerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data users
        $staff = User::where('role', 'staff')->get();
        $kasi = User::where('role', 'kasi')->get();

        // Buat tasks sample
        $tasks = [
            ['nama_tugas' => 'Menyusun Laporan Bulanan', 'deskripsi' => 'Membuat laporan kinerja bulanan', 'kategori' => 'Administrasi'],
            ['nama_tugas' => 'Membuat Presentasi', 'deskripsi' => 'Menyiapkan presentasi untuk rapat', 'kategori' => 'Presentasi'],
            ['nama_tugas' => 'Mengelola Database', 'deskripsi' => 'Update dan maintenance database', 'kategori' => 'IT'],
            ['nama_tugas' => 'Koordinasi Tim', 'deskripsi' => 'Koordinasi dengan tim terkait', 'kategori' => 'Koordinasi'],
            ['nama_tugas' => 'Analisis Data', 'deskripsi' => 'Menganalisis data kinerja', 'kategori' => 'Analisis'],
        ];

        foreach ($tasks as $taskData) {
            Task::create($taskData);
        }

        $createdTasks = Task::all();

        // Buat targets dan realisasi untuk setiap staff
        foreach ($staff as $staffMember) {
            // Buat 2-3 target per staff
            for ($i = 1; $i <= 3; $i++) {
                $task = $createdTasks->random();
                
                $targetKuantitas = rand(5, 20);
                $targetWaktu = rand(7, 30);
                
                // Buat target
                $target = Target::create([
                    'user_id' => $staffMember->id,
                    'tugas_id' => $task->id,
                    'tahun' => 2025,
                    'triwulan' => 'I',
                    'target_kuantitas' => $targetKuantitas,
                    'target_waktu' => $targetWaktu,
                    'deskripsi_tugas' => $task->deskripsi,
                    'status' => 'aktif',
                ]);

                // Buat realisasi kinerja
                $realisasi = RealisasiKinerja::create([
                    'user_id' => $staffMember->id,
                    'tugas_id' => $task->id,
                    'tahun' => 2025,
                    'triwulan' => 'I',
                    'target_kuantitas' => $targetKuantitas,
                    'realisasi_kuantitas' => rand($targetKuantitas - 2, $targetKuantitas + 5),
                    'target_waktu' => $targetWaktu,
                    'realisasi_waktu' => rand($targetWaktu - 3, $targetWaktu + 7),
                    'kualitas' => rand(75, 95),
                    'link_bukti' => 'https://drive.google.com/file/d/dokumen_' . $staffMember->id . '_' . $i,
                    'status' => 'dikirim', // Status dikirim agar bisa dinilai kasi
                ]);

                // Buat komentar/penilaian dari kasi (jika staff punya atasan)
                if ($staffMember->kasi_id) {
                    Comment::create([
                        'user_id' => $staffMember->id,
                        'realisasi_kinerja_id' => $realisasi->id,
                        'komentar' => $this->generateComment(),
                        'rating' => rand(1, 3), // Rating 1-3 sesuai sistem
                        'is_read' => false,
                        'created_by' => $staffMember->kasi_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    private function generateComment()
    {
        $comments = [
            'Pekerjaan sudah baik, namun masih perlu peningkatan dalam hal ketepatan waktu.',
            'Hasil kerja memuaskan dan sesuai dengan target yang ditetapkan.',
            'Kinerja sangat baik, melebihi ekspektasi yang diharapkan.',
            'Perlu lebih fokus pada kualitas output agar hasil lebih maksimal.',
            'Sudah menunjukkan improvement yang signifikan dari periode sebelumnya.',
            'Koordinasi dengan tim sudah baik, pertahankan kinerja ini.',
            'Masih ada beberapa hal yang perlu diperbaiki untuk mencapai target optimal.',
            'Sangat memuaskan, terus tingkatkan kinerja seperti ini.',
        ];

        return $comments[array_rand($comments)];
    }
}