<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nip',
        'jabatan',
        'email',
        'password',
        'role',
        'kasi_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: Staff belongsTo Kasi
     * Hanya untuk user dengan role 'staff'
     */
    public function kasi()
    {
        return $this->belongsTo(User::class, 'kasi_id');
    }

    /**
     * Relasi: Kasi hasMany Staff
     * Hanya untuk user dengan role 'kasi'
     */
    public function staffs()
    {
        return $this->hasMany(User::class, 'kasi_id')
                    ->where('role', 'staff')
                    ->where('status', 'aktif');
    }

    /**
     * Scope: Hanya user dengan role tertentu
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope: Hanya Kasi
     */
    public function scopeKasi($query)
    {
        return $query->where('role', 'kasi');
    }

    /**
     * Scope: Hanya Staff
     */
    public function scopeStaff($query)
    {
        return $query->where('role', 'staff');
    }

    /**
     * Scope: Hanya Kepala
     */
    public function scopeKepala($query)
    {
        return $query->where('role', 'kepala');
    }

    /**
     * Helper: Cek apakah user adalah Kasi
     */
    public function isKasi()
    {
        return $this->role === 'kasi';
    }

    /**
     * Helper: Cek apakah user adalah Staff
     */
    public function isStaff()
    {
        return $this->role === 'staff';
    }

    /**
     * Helper: Cek apakah user adalah Kepala
     */
    public function isKepala()
    {
        return $this->role === 'kepala';
    }

    /**
     * Helper: Dapatkan nama atasan (untuk staff)
     */
    public function getAtasanNameAttribute()
    {
        if ($this->isStaff() && $this->kasi) {
            return $this->kasi->name;
        }
        return null;
    }

    /**
     * Helper: Dapatkan jumlah staff (untuk kasi)
     */
    public function getJumlahStaffAttribute()
    {
        if ($this->isKasi()) {
            return $this->staffs()->count();
        }
        return 0;
    }
}
