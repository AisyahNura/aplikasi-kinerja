<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianStaff extends Model
{
    protected $table = 'penilaian_staff';
    
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
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Relasi ke kasi yang menilai
     */
    public function kasi()
    {
        return $this->belongsTo(User::class, 'kasi_id');
    }
}
