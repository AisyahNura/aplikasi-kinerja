<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * PenilaianStaff Model - Model untuk menyimpan penilaian kinerja staff dari KASI
 * 
 * FLOW SISTEM PENILAIAN STAFF:
 * 1. KASI review realisasi kinerja staff setiap triwulan
 * 2. KASI memberikan rating (1-3) dan komentar
 * 3. Penilaian disimpan per periode (tahun/triwulan)
 * 4. Staff dapat melihat penilaian yang diberikan
 * 5. Data penilaian digunakan untuk evaluasi kinerja
 * 
 * RELASI MODEL:
 * - belongsTo User (staff yang dinilai)
 * - belongsTo User (KASI yang menilai)
 * 
 * RATING SYSTEM:
 * - 1: Kurang baik (perlu perbaikan)
 * - 2: Cukup baik (sesuai standar)
 * - 3: Sangat baik (melebihi standar)
 * 
 * PERIODE PENILAIAN:
 * - Dilakukan setiap triwulan (I, II, III, IV)
 * - Setiap tahun dapat memiliki penilaian berbeda
 * - Penilaian dapat diupdate jika ada perubahan
 */
class PenilaianStaff extends Model
{
    protected $table = 'penilaian_staff';
    
    /**
     * Field yang dapat diisi secara massal
     * FLOW: Field ini akan diisi saat KASI memberikan penilaian
     */
    protected $fillable = [
        'staff_id',
        'kasi_id',
        'tahun',
        'triwulan',
        'rating',
        'komentar'
    ];

    /**
     * Relasi ke staff yang dinilai
     * FLOW: Setiap penilaian ditujukan kepada satu staff
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Relasi ke kasi yang menilai
     * FLOW: Setiap penilaian dibuat oleh satu KASI
     */
    public function kasi()
    {
        return $this->belongsTo(User::class, 'kasi_id');
    }
}
