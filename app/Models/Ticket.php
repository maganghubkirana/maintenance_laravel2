<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke User (Pelapor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}