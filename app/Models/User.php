<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use Notifiable;

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'permissions',
    ];

    /*
    |--------------------------------------------------------------------------
    | Hidden Attributes
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'permissions' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('user')
            ->dontLogIfAttributesChangedOnly(['remember_token']) // Abaikan log jika hanya remember_token yang berubah
            ->logExcept(['password']) // JANGAN CATAT PASSWORD KE LOG DEMI KEAMANAN
            ->setDescriptionForEvent(fn(string $eventName) => "Akun user telah di-{$eventName}");
    }

    /*
    |--------------------------------------------------------------------------
    | Permission
    |--------------------------------------------------------------------------
    */

    public function hasPermission(string $permission): bool
    {
        /*
        |--------------------------------------------------------------------------
        | SUPERADMIN memiliki semua permission
        |--------------------------------------------------------------------------
        */

        if (strtoupper($this->role) === 'SUPERADMIN') {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | User biasa
        |--------------------------------------------------------------------------
        */

        return is_array($this->permissions)
            && in_array(
                $permission,
                $this->permissions,
                true
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Maintenance Relationship
    |--------------------------------------------------------------------------
    */

    public function maintenanceRequests()
    {
        return $this->hasMany(
            MaintenanceRequest::class,
            'engineer_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Approval History Relationship
    |--------------------------------------------------------------------------
    */

    public function approvalHistory()
    {
        return $this->hasMany(
            ApprovalHistory::class
        );
    }
}