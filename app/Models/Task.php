<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'nama_tugas',
        'deskripsi',
        'kategori',
        'status',
    ];

    /**
     * Relasi ke Target
     */
    public function targets(): HasMany
    {
        return $this->hasMany(Target::class, 'tugas_id');
    }

    /**
     * Relasi ke RealisasiKinerja
     */
    public function realisasiKinerja(): HasMany
    {
        return $this->hasMany(RealisasiKinerja::class, 'tugas_id');
    }
} 