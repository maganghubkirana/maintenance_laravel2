<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'permissions', // Ditambahkan untuk menyimpan array hak akses
    ];

    /**
     * Attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permissions' => 'array', // Otomatis konversi format JSON dari DB ke Array di PHP
    ];

    // ==========================================
    // HELPER PERMISSION (HAK AKSES)
    // ==========================================

    /**
     * Cek apakah user memiliki izin untuk mengakses modul tertentu.
     */
    public function hasPermission(string $permission): bool
    {
        // SUPERADMIN otomatis selalu memiliki hak akses penuh ke semua modul
        if (strtoupper($this->role) === 'SUPERADMIN') {
            return true;
        }

        return is_array($this->permissions) && in_array($permission, $this->permissions);
    }

    // ==========================================
    // RELASI DATABASE
    // ==========================================

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'engineer_id');
    }

    public function approvalHistory()
    {
        return $this->hasMany(ApprovalHistory::class);
    }
}