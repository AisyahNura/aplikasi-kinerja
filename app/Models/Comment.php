<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Comment Model - Model untuk menyimpan komentar dan penilaian dari KASI ke Staff
 * 
 * FLOW SISTEM KOMENTAR:
 * 1. Staff mengirim realisasi kinerja ke KASI
 * 2. KASI review realisasi kinerja staff
 * 3. KASI memberikan komentar dan rating (1-3)
 * 4. Staff dapat melihat komentar dan rating
 * 5. Staff dapat mark komentar sebagai sudah dibaca
 * 
 * RELASI MODEL:
 * - belongsTo User (staff yang menerima komentar)
 * - belongsTo RealisasiKinerja (kinerja yang dikomentari)
 * - belongsTo User (KASI yang membuat komentar)
 * 
 * RATING SYSTEM:
 * - 1: Kurang baik
 * - 2: Cukup baik
 * - 3: Sangat baik
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * Field yang dapat diisi secara massal
     * FLOW: Field ini akan diisi saat KASI membuat komentar
     */
    protected $fillable = [
        'user_id',
        'realisasi_kinerja_id',
        'komentar',
        'rating',
        'is_read',
        'created_by',
    ];

    /**
     * Field yang akan di-cast ke tipe data tertentu
     * FLOW: Memastikan field is_read tersimpan sebagai boolean
     */
    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relasi ke User (Staff yang menerima komentar)
     * FLOW: Setiap komentar ditujukan kepada satu staff
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke RealisasiKinerja
     * FLOW: Setiap komentar terkait dengan satu realisasi kinerja
     */
    public function realisasiKinerja(): BelongsTo
    {
        return $this->belongsTo(RealisasiKinerja::class);
    }

    /**
     * Relasi ke User yang membuat komentar (Kasi)
     * FLOW: Setiap komentar dibuat oleh satu KASI
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope untuk komentar yang belum dibaca
     * FLOW: Memudahkan query komentar yang belum dibaca staff
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope untuk komentar berdasarkan user
     * FLOW: Memudahkan query komentar untuk staff tertentu
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
} 