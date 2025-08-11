<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Target Model - Model untuk menyimpan target kinerja staff setiap periode
 * 
 * FLOW SISTEM TARGET:
 * 1. KASI/Admin membuat target kinerja untuk staff
 * 2. Target dibuat per periode (tahun/triwulan)
 * 3. Staff dapat melihat target yang harus dicapai
 * 4. Staff input realisasi aktual berdasarkan target
 * 5. KASI review apakah target tercapai
 * 
 * RELASI MODEL:
 * - belongsTo User (staff yang memiliki target)
 * - belongsTo Task (tugas yang ditargetkan)
 * - hasMany RealisasiKinerja (realisasi aktual dari target)
 * 
 * PERIODE TARGET:
 * - Tahun: 2024, 2025, dst
 * - Triwulan: I, II, III, IV
 * - Setiap periode dapat memiliki target berbeda
 */
class Target extends Model
{
    use HasFactory;

    /**
     * Field yang dapat diisi secara massal
     * FLOW: Field ini akan diisi saat KASI membuat target kinerja
     */
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

    /**
     * Field yang akan di-cast ke tipe data tertentu
     * FLOW: Memastikan data numerik tersimpan dengan tipe yang benar
     */
    protected $casts = [
        'tahun' => 'integer',
        'target_kuantitas' => 'integer',
        'target_waktu' => 'integer',
    ];

    /**
     * Relasi ke User (Staff)
     * FLOW: Setiap target dimiliki oleh satu staff
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Task
     * FLOW: Setiap target terkait dengan satu tugas
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'tugas_id');
    }

    /**
     * Relasi ke RealisasiKinerja
     * FLOW: Satu target dapat memiliki banyak realisasi aktual
     */
    public function realisasiKinerja(): HasMany
    {
        return $this->hasMany(RealisasiKinerja::class, 'tugas_id', 'tugas_id');
    }

    /**
     * Scope untuk filter berdasarkan tahun dan triwulan
     * FLOW: Memudahkan query target berdasarkan periode tertentu
     */
    public function scopeByPeriod($query, $tahun, $triwulan)
    {
        return $query->where('tahun', $tahun)->where('triwulan', $triwulan);
    }

    /**
     * Scope untuk filter berdasarkan user
     * FLOW: Memudahkan query target untuk staff tertentu
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
} 