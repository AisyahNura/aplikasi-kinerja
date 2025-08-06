<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tugas_id',
        'tahun',
        'triwulan',
        'target_kuantitas',
        'target_waktu',
        'deskripsi_tugas',
        'status',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'target_kuantitas' => 'integer',
        'target_waktu' => 'integer',
    ];

    /**
     * Relasi ke User (Staff)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Task
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'tugas_id');
    }

    /**
     * Relasi ke RealisasiKinerja
     */
    public function realisasiKinerja(): HasMany
    {
        return $this->hasMany(RealisasiKinerja::class, 'tugas_id', 'tugas_id');
    }

    /**
     * Scope untuk filter berdasarkan tahun dan triwulan
     */
    public function scopeByPeriod($query, $tahun, $triwulan)
    {
        return $query->where('tahun', $tahun)->where('triwulan', $triwulan);
    }

    /**
     * Scope untuk filter berdasarkan user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
} 