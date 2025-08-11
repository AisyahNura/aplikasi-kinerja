<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Task Model - Model untuk menyimpan daftar tugas yang dapat dikerjakan staff
 * 
 * FLOW SISTEM TASK:
 * 1. Admin/KASI membuat daftar tugas yang tersedia
 * 2. Staff memilih tugas yang akan dikerjakan
 * 3. Staff input target dan realisasi untuk tugas tersebut
 * 4. KASI review dan berikan penilaian
 * 5. Task dapat memiliki status aktif/nonaktif
 * 
 * RELASI MODEL:
 * - hasMany Target (target kinerja untuk setiap periode)
 * - hasMany RealisasiKinerja (realisasi aktual dari staff)
 * 
 * KATEGORI TASK:
 * - Administrasi: Tugas administrasi rutin
 * - Proyek: Tugas proyek khusus
 * - Laporan: Pembuatan laporan
 * - Lainnya: Tugas lainnya
 */
class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    /**
     * Field yang dapat diisi secara massal
     * FLOW: Field ini akan diisi saat admin membuat atau edit tugas
     */
    protected $fillable = [
        'nama_tugas',
        'deskripsi',
        'kategori',
        'status',
    ];

    /**
     * Relasi ke Target
     * FLOW: Satu tugas dapat memiliki banyak target untuk periode berbeda
     */
    public function targets(): HasMany
    {
        return $this->hasMany(Target::class, 'tugas_id');
    }

    /**
     * Relasi ke RealisasiKinerja
     * FLOW: Satu tugas dapat memiliki banyak realisasi dari staff berbeda
     */
    public function realisasiKinerja(): HasMany
    {
        return $this->hasMany(RealisasiKinerja::class, 'tugas_id');
    }
} 