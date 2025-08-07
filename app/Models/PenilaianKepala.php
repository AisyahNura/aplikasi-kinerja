<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianKepala extends Model
{
    use HasFactory;

    protected $table = 'penilaian_kepala';

    protected $fillable = [
        'kasi_id',
        'tahun',
        'triwulan',
        'rating',
        'komentar',
        'created_by'
    ];

    protected $casts = [
        'tahun' => 'integer',
        'rating' => 'integer',
    ];

    /**
     * Relasi: PenilaianKepala belongsTo Kasi
     */
    public function kasi()
    {
        return $this->belongsTo(User::class, 'kasi_id');
    }

    /**
     * Relasi: PenilaianKepala belongsTo Kepala (yang menilai)
     */
    public function kepala()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope: Filter berdasarkan tahun dan triwulan
     */
    public function scopePeriode($query, $tahun, $triwulan)
    {
        return $query->where('tahun', $tahun)
                    ->where('triwulan', $triwulan);
    }

    /**
     * Scope: Filter berdasarkan Kasi
     */
    public function scopeKasi($query, $kasiId)
    {
        return $query->where('kasi_id', $kasiId);
    }

    /**
     * Helper: Dapatkan label rating
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
