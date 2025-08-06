<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kepala Kantor
        $kepala = User::create([
            'name' => 'Kepala Kantor',
            'nip' => '333333333333333333',
            'jabatan' => 'Kepala Kantor',
            'email' => 'kepala.kantor@kemenag.go.id',
            'password' => Hash::make('12345678'),
            'role' => 'kepala',
        ]);

        // 2. Kasi 1 - Pendidikan Madrasah
        $kasi1 = User::create([
            'name' => 'Dr. Ahmad Subhan, M.Pd',
            'nip' => '197504151998031001',
            'jabatan' => 'Kasi Pendidikan Madrasah',
            'email' => 'kasi.pendma@kemenag.go.id',
            'password' => Hash::make('12345678'),
            'role' => 'kasi',
        ]);

        // 3. Kasi 2 - Penyelenggaraan Haji
        $kasi2 = User::create([
            'name' => 'Dra. Siti Aminah, M.Ag',
            'nip' => '198203101999032002',
            'jabatan' => 'Kasi Penyelenggaraan Haji',
            'email' => 'kasi.haji@kemenag.go.id',
            'password' => Hash::make('12345678'),
            'role' => 'kasi',
        ]);

        // 4. Staff di bawah Kasi 1 (Pendidikan Madrasah)
        User::create([
            'name' => 'Tumaji',
            'nip' => '197801252011011006',
            'jabatan' => 'Pranata Komputer Ahli Pertama',
            'email' => 'tumaji@kemenag.go.id',
            'password' => Hash::make('12345678'),
            'role' => 'staff',
            'kasi_id' => $kasi1->id, // Staff ini di bawah Kasi 1
        ]);

        User::create([
            'name' => 'Meseri',
            'nip' => '198003152010012001',
            'jabatan' => 'Pranata Komputer Ahli Pertama',
            'email' => 'meseri@kemenag.go.id',
            'password' => Hash::make('12345678'),
            'role' => 'staff',
            'kasi_id' => $kasi1->id, // Staff ini di bawah Kasi 1
        ]);

        // 5. Staff di bawah Kasi 2 (Penyelenggaraan Haji)
        User::create([
            'name' => 'Pancahadi Siswa Asusila',
            'nip' => '198505102011011007',
            'jabatan' => 'Pranata Komputer Ahli Pertama',
            'email' => 'pancahadi@kemenag.go.id',
            'password' => Hash::make('12345678'),
            'role' => 'staff',
            'kasi_id' => $kasi2->id, // Staff ini di bawah Kasi 2
        ]);

        // 6. Staff tambahan untuk testing
        User::create([
            'name' => 'Budi Santoso',
            'nip' => '199001152015031001',
            'jabatan' => 'Analis Data',
            'email' => 'budi.santoso@kemenag.go.id',
            'password' => Hash::make('12345678'),
            'role' => 'staff',
            'kasi_id' => $kasi1->id, // Staff ini di bawah Kasi 1
        ]);

        User::create([
            'name' => 'Sari Dewi',
            'nip' => '199205102016032002',
            'jabatan' => 'Admin Haji',
            'email' => 'sari.dewi@kemenag.go.id',
            'password' => Hash::make('12345678'),
            'role' => 'staff',
            'kasi_id' => $kasi2->id, // Staff ini di bawah Kasi 2
        ]);
    }
} 