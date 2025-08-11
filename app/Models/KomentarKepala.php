<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * KomentarKepala Model - Model untuk menyimpan komentar umum dari Kepala
 * 
 * FLOW SISTEM KOMENTAR KEPALA:
 * 1. Kepala dapat memberikan komentar umum untuk setiap periode
 * 2. Komentar dapat berupa arahan, evaluasi, atau feedback umum
 * 3. Komentar disimpan per periode (tahun/triwulan)
 * 4. Semua staff dan KASI dapat melihat komentar Kepala
 * 5. Komentar digunakan sebagai panduan kinerja organisasi
 * 
 * KEGUNAAN KOMENTAR:
 * - Arahan kinerja untuk periode tertentu
 * - Evaluasi kinerja organisasi secara umum
 * - Feedback dan saran perbaikan
 * - Motivasi dan apresiasi tim
 * 
 * PERIODE KOMENTAR:
 * - Dilakukan setiap triwulan (I, II, III, IV)
 * - Setiap tahun dapat memiliki komentar berbeda
 * - Komentar dapat diupdate jika ada perubahan
 */
class KomentarKepala extends Model
{
    use HasFactory;

    protected $table = 'komentar_kepala';

    /**
     * Field yang dapat diisi secara massal
     * FLOW: Field ini akan diisi saat Kepala memberikan komentar umum
     */
    protected $fillable = [
        'tahun',
        'triwulan',
        'komentar'
    ];

    /**
     * Field yang akan di-cast ke tipe data tertentu
     * FLOW: Memastikan data tahun tersimpan dengan tipe yang benar
     */
    protected $casts = [
        'tahun' => 'integer',
    ];
} 