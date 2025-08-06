<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'realisasi_kinerja_id',
        'komentar',
        'rating',
        'is_read',
        'created_by',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relasi ke User (Staff yang menerima komentar)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke RealisasiKinerja
     */
    public function realisasiKinerja(): BelongsTo
    {
        return $this->belongsTo(RealisasiKinerja::class);
    }

    /**
     * Relasi ke User yang membuat komentar (Kasi)
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope untuk komentar yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope untuk komentar berdasarkan user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
} 