<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * PenilaianKepala Model - Model untuk menyimpan penilaian kinerja KASI dari Kepala
 * 
 * FLOW SISTEM PENILAIAN KASI:
 * 1. Kepala review kinerja KASI setiap triwulan
 * 2. Kepala memberikan rating (1-3) dan komentar
 * 3. Penilaian disimpan per periode (tahun/triwulan)
 * 4. KASI dapat melihat penilaian yang diberikan
 * 5. Data penilaian digunakan untuk evaluasi kinerja KASI
 * 
 * RELASI MODEL:
 * - belongsTo User (KASI yang dinilai)
 * - belongsTo User (Kepala yang menilai)
 * 
 * RATING SYSTEM:
 * - 1: Di Bawah Ekspektasi (perlu perbaikan)
 * - 2: Sesuai Ekspektasi (sesuai standar)
 * - 3: Melebihi Ekspektasi (melebihi standar)
 * 
 * PERIODE PENILAIAN:
 * - Dilakukan setiap triwulan (I, II, III, IV)
 * - Setiap tahun dapat memiliki penilaian berbeda
 * - Penilaian dapat diupdate jika ada perubahan
 */
class PenilaianKepala extends Model
{
    use HasFactory;

    protected $table = 'penilaian_kepala';

    /**
     * Field yang dapat diisi secara massal
     * FLOW: Field ini akan diisi saat Kepala memberikan penilaian
     */
    protected $fillable = [
        'kasi_id',
        'tahun',
        'triwulan',
        'rating',
        'komentar',
        'created_by'
    ];

    /**
     * Field yang akan di-cast ke tipe data tertentu
     * FLOW: Memastikan data numerik tersimpan dengan tipe yang benar
     */
    protected $casts = [
        'tahun' => 'integer',
        'rating' => 'integer',
    ];

    /**
     * Relasi: PenilaianKepala belongsTo Kasi
     * FLOW: Setiap penilaian ditujukan kepada satu KASI
     */
    public function kasi()
    {
        return $this->belongsTo(User::class, 'kasi_id');
    }

    /**
     * Relasi: PenilaianKepala belongsTo Kepala (yang menilai)
     * FLOW: Setiap penilaian dibuat oleh satu Kepala
     */
    public function kepala()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope: Filter berdasarkan tahun dan triwulan
     * FLOW: Memudahkan query penilaian berdasarkan periode tertentu
     */
    public function scopePeriode($query, $tahun, $triwulan)
    {
        return $query->where('tahun', $tahun)
                    ->where('triwulan', $triwulan);
    }

    /**
     * Scope: Filter berdasarkan Kasi
     * FLOW: Memudahkan query penilaian untuk KASI tertentu
     */
    public function scopeKasi($query, $kasiId)
    {
        return $query->where('kasi_id', $kasiId);
    }

    /**
     * Helper: Dapatkan label rating
     * FLOW: Convert rating numerik ke label yang mudah dibaca
     */
    public function getRatingLabelAttribute()
    {
        switch ($this->rating) {
            case 1:
                return 'Di Bawah Ekspektasi';
            case 2:
                return 'Sesuai Ekspektasi';
            case 3:
                return 'Melebihi Ekspektasi';
            default:
                return 'Tidak Ada Rating';
        }
    }

    /**
     * Helper: Dapatkan warna rating
     * FLOW: Convert rating ke warna untuk tampilan UI
     */
    public function getRatingColorAttribute()
    {
        switch ($this->rating) {
            case 1:
                return 'red';
            case 2:
                return 'yellow';
            case 3:
                return 'green';
            default:
                return 'gray';
        }
    }
}
