<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarKepala extends Model
{
    use HasFactory;

    protected $table = 'komentar_kepala';

    protected $fillable = [
        'tahun',
        'triwulan',
        'komentar'
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];
} 