<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreventiveMaintenance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class); // Sesuaikan dengan Model Equipment Anda
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
