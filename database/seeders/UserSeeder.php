<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kepala users
        User::create([
            'name' => 'Dr. MUHAJIR, S.Pd., M.Ag',
            'email' => 'muhajir.kepala@kemenag.go.id',
            'password' => Hash::make('197304131999031003'),
            'nip' => '197304131999031003',
            'jabatan' => 'Kepala Kantor Kementerian Agama',
            'role' => 'kepala',
        ]);

        // Kasi users
        User::create([
            'name' => 'Ahmad Kasi',
            'email' => 'ahmad.kasi@kemenag.go.id',
            'password' => Hash::make('197504151998031001'),
            'nip' => '197504151998031001',
            'jabatan' => 'Kasi Pendidikan Madrasah',
            'role' => 'kasi',
        ]);

        User::create([
            'name' => 'Siti Kasi',
            'email' => 'siti.kasi@kemenag.go.id',
            'password' => Hash::make('197812202000032001'),
            'nip' => '197812202000032001',
            'jabatan' => 'Kasi Haji dan Umrah',
            'role' => 'kasi',
        ]);

        // Staff users
        User::create([
            'name' => 'Andi Saputra',
            'email' => 'andi.saputra@kemenag.go.id',
            'password' => Hash::make('197801252011011006'),
            'nip' => '197801252011011006',
            'jabatan' => 'Staff Pendidikan',
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@kemenag.go.id',
            'password' => Hash::make('198503152010011001'),
            'nip' => '198503152010011001',
            'jabatan' => 'Staff Madrasah',
            'role' => 'staff',
        ]);
    }
} 