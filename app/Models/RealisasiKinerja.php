<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RealisasiKinerja extends Model
{
    use HasFactory;

    protected $table = 'realisasi_kinerja';

    protected $fillable = [
        'user_id',
        'tugas_id',
        'tahun',
        'triwulan',
        'target_kuantitas',
        'realisasi_kuantitas',
        'target_waktu',
        'realisasi_waktu',
        'kualitas',
        'link_bukti',
        'status',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'target_kuantitas' => 'integer',
        'realisasi_kuantitas' => 'integer',
        'target_waktu' => 'integer',
        'realisasi_waktu' => 'integer',
        'kualitas' => 'integer',
    ];

    /**
     * Relasi ke User
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
     * Relasi ke Comment
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
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

    /**
     * Cek apakah target tercapai
     */
    public function isTargetAchieved(): bool
    {
        return $this->realisasi_kuantitas >= $this->target_kuantitas && 
               $this->realisasi_waktu <= $this->target_waktu;
    }
} 
