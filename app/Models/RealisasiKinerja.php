<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * RealisasiKinerja Model - Model untuk menyimpan realisasi kinerja staff
 * 
 * FLOW SISTEM REALISASI KINERJA:
 * 1. Staff input target kinerja (kuantitas, waktu)
 * 2. Staff input realisasi aktual (kuantitas, waktu, kualitas)
 * 3. Staff upload bukti kerja (link dokumen)
 * 4. Status berubah dari 'draft' ke 'dikirim'
 * 5. KASI review dan berikan komentar
 * 6. Status dapat berubah ke 'selesai' jika disetujui
 * 
 * RELASI MODEL:
 * - belongsTo User (staff yang input)
 * - belongsTo Task (tugas yang dikerjakan)
 * - hasMany Comment (komentar dari KASI)
 * 
 * STATUS REALISASI:
 * - draft: Belum dikirim ke KASI
 * - dikirim: Sudah dikirim ke KASI untuk review
 * - selesai: Sudah direview dan disetujui KASI
 */
class RealisasiKinerja extends Model
{
    use HasFactory;

    protected $table = 'realisasi_kinerja';

    /**
     * Field yang dapat diisi secara massal
     * FLOW: Field ini akan diisi saat create/update realisasi kinerja
     */
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

    /**
     * Field yang akan di-cast ke tipe data tertentu
     * FLOW: Memastikan data tersimpan dengan tipe yang benar
     */
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
     * FLOW: Setiap realisasi kinerja dimiliki oleh satu staff
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Task
     * FLOW: Setiap realisasi kinerja terkait dengan satu tugas
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'tugas_id');
    }

    /**
     * Relasi ke Comment
     * FLOW: Satu realisasi kinerja dapat memiliki banyak komentar dari KASI
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope untuk filter berdasarkan tahun dan triwulan
     * FLOW: Memudahkan query data berdasarkan periode tertentu
     */
    public function scopeByPeriod($query, $tahun, $triwulan)
    {
        return $query->where('tahun', $tahun)->where('triwulan', $triwulan);
    }

    /**
     * Scope untuk filter berdasarkan user
     * FLOW: Memudahkan query data berdasarkan staff tertentu
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Cek apakah target tercapai
     * FLOW: 
     * 1. Bandingkan realisasi kuantitas dengan target
     * 2. Bandingkan realisasi waktu dengan target
     * 3. Return true jika target tercapai
     */
    public function isTargetAchieved(): bool
    {
        return $this->realisasi_kuantitas >= $this->target_kuantitas && 
               $this->realisasi_waktu <= $this->target_waktu;
    }
} 
