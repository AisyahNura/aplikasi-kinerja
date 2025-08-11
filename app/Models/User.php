<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Model - Model utama untuk semua user dalam sistem
 * 
 * FLOW SISTEM USER:
 * 1. User memiliki role: 'staff', 'kasi', atau 'kepala'
 * 2. Staff belongsTo KASI (relasi kasi_id)
 * 3. KASI hasMany Staff (relasi staffs)
 * 4. Setiap role memiliki scope dan helper method
 * 5. Relasi hierarkis: Kepala -> KASI -> Staff
 * 
 * STRUKTUR RELASI:
 * - Kepala: Tidak memiliki atasan, dapat melihat semua KASI
 * - KASI: Memiliki staff yang berada di bawahnya
 * - Staff: Memiliki KASI sebagai atasan langsung
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * FLOW: Field yang dapat diisi secara massal saat create/update
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
     * FLOW: Field yang disembunyikan saat response JSON/array
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     * FLOW: Field yang akan di-cast ke tipe data tertentu
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
     * FLOW: Staff dapat mengakses data KASI yang menjadi atasannya
     * Hanya untuk user dengan role 'staff'
     */
    public function kasi()
    {
        return $this->belongsTo(User::class, 'kasi_id');
    }

    /**
     * Relasi: Kasi hasMany Staff
     * FLOW: KASI dapat mengakses semua staff yang berada di bawahnya
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
     * FLOW: Filter query berdasarkan role user
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope: Hanya Kasi
     * FLOW: Filter query untuk user dengan role 'kasi'
     */
    public function scopeKasi($query)
    {
        return $query->where('role', 'kasi');
    }

    /**
     * Scope: Hanya Staff
     * FLOW: Filter query untuk user dengan role 'staff'
     */
    public function scopeStaff($query)
    {
        return $query->where('role', 'staff');
    }

    /**
     * Scope: Hanya Kepala
     * FLOW: Filter query untuk user dengan role 'kepala'
     */
    public function scopeKepala($query)
    {
        return $query->where('role', 'kepala');
    }

    /**
     * Helper: Cek apakah user adalah Kasi
     * FLOW: Return boolean true jika role = 'kasi'
     */
    public function isKasi()
    {
        return $this->role === 'kasi';
    }

    /**
     * Helper: Cek apakah user adalah Staff
     * FLOW: Return boolean true jika role = 'staff'
     */
    public function isStaff()
    {
        return $this->role === 'staff';
    }

    /**
     * Helper: Cek apakah user adalah Kepala
     * FLOW: Return boolean true jika role = 'kepala'
     */
    public function isKepala()
    {
        return $this->role === 'kepala';
    }

    /**
     * Helper: Dapatkan nama atasan (untuk staff)
     * FLOW: Staff dapat mengakses nama KASI yang menjadi atasannya
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
     * FLOW: KASI dapat melihat berapa staff yang berada di bawahnya
     */
    public function getJumlahStaffAttribute()
    {
        if ($this->isKasi()) {
            return $this->staffs()->count();
        }
        return 0;
    }
}
