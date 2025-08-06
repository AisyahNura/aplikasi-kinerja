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
        // Staff users
        User::create([
            'name' => 'Andi Saputra',
            'email' => 'andi.saputra@kemenag.go.id',
            'password' => Hash::make('197801252011011006'), // NIP as password
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@kemenag.go.id',
            'password' => Hash::make('198503152010011001'), // NIP as password
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Citra Dewi',
            'email' => 'citra.dewi@kemenag.go.id',
            'password' => Hash::make('199004202012012002'), // NIP as password
            'role' => 'staff',
        ]);

        // Kasi users
        User::create([
            'name' => 'Dr. Ahmad Kasi',
            'email' => 'ahmad.kasi@kemenag.go.id',
            'password' => Hash::make('197504151998031001'), // NIP as password
            'role' => 'kasi',
        ]);

        User::create([
            'name' => 'Siti Kasi',
            'email' => 'siti.kasi@kemenag.go.id',
            'password' => Hash::make('197812202000032001'), // NIP as password
            'role' => 'kasi',
        ]);

        // Kepala users
        User::create([
            'name' => 'Dr. MUHAJIR, S.Pd., M.Ag',
            'email' => 'muhajir.kepala@kemenag.go.id',
            'password' => Hash::make('197304131999031003'), // NIP as password
            'role' => 'kepala',
        ]);

        User::create([
            'name' => 'Ir. Kepala Kantor',
            'email' => 'kepala.kantor@kemenag.go.id',
            'password' => Hash::make('197001011990031001'), // NIP as password
            'role' => 'kepala',
        ]);
    }
} 