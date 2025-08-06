<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\RealisasiKinerja;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user untuk testing
        $staff = User::firstOrCreate([
            'email' => 'staff@example.com'
        ], [
            'name' => 'Demo Staff',
            'password' => bcrypt('password'),
            'role' => 'staff'
        ]);

        $kasi = User::firstOrCreate([
            'email' => 'kasi@example.com'
        ], [
            'name' => 'Demo Kasi',
            'password' => bcrypt('password'),
            'role' => 'kasi'
        ]);

        $kepala = User::firstOrCreate([
            'email' => 'kepala@example.com'
        ], [
            'name' => 'Demo Kepala Kantor',
            'password' => bcrypt('password'),
            'role' => 'kepala'
        ]);

        // Ambil realisasi kinerja yang ada
        $realisasiKinerja = RealisasiKinerja::where('user_id', $staff->id)->first();

        if ($realisasiKinerja) {
            // Buat komentar dari Kasi - Melebihi Ekspektasi
            Comment::firstOrCreate([
                'user_id' => $staff->id,
                'realisasi_kinerja_id' => $realisasiKinerja->id,
                'created_by' => $kasi->id,
                'komentar' => 'Kinerja yang sangat baik. Anda telah menyelesaikan tugas dengan tepat waktu dan hasil yang memuaskan. Terus pertahankan semangat kerja yang tinggi!',
                'rating' => 3,
                'is_read' => false
            ]);

            // Buat komentar dari Kepala Kantor - Melebihi Ekspektasi
            Comment::firstOrCreate([
                'user_id' => $staff->id,
                'realisasi_kinerja_id' => $realisasiKinerja->id,
                'created_by' => $kepala->id,
                'komentar' => 'Hasil kerja yang konsisten dan berkualitas. Saya sangat puas dengan dedikasi Anda dalam menyelesaikan tugas-tugas yang diberikan.',
                'rating' => 3,
                'is_read' => true
            ]);

            // Buat komentar lain dari Kasi - Sesuai Ekspektasi
            Comment::firstOrCreate([
                'user_id' => $staff->id,
                'realisasi_kinerja_id' => $realisasiKinerja->id,
                'created_by' => $kasi->id,
                'komentar' => 'Ada beberapa hal yang perlu diperbaiki dalam pelaporan. Mohon perhatikan detail dan format yang diminta.',
                'rating' => 2,
                'is_read' => false
            ]);

            // Buat komentar tambahan - Di Bawah Ekspektasi
            Comment::firstOrCreate([
                'user_id' => $staff->id,
                'realisasi_kinerja_id' => $realisasiKinerja->id,
                'created_by' => $kepala->id,
                'komentar' => 'Perlu peningkatan dalam ketepatan waktu dan kualitas hasil kerja. Mohon lebih teliti dalam menyelesaikan tugas.',
                'rating' => 1,
                'is_read' => true
            ]);

            // Buat komentar tambahan - Sesuai Ekspektasi
            Comment::firstOrCreate([
                'user_id' => $staff->id,
                'realisasi_kinerja_id' => $realisasiKinerja->id,
                'created_by' => $kasi->id,
                'komentar' => 'Kinerja cukup baik, namun masih ada ruang untuk peningkatan dalam hal inovasi dan kreativitas.',
                'rating' => 2,
                'is_read' => false
            ]);
        }
    }
}
