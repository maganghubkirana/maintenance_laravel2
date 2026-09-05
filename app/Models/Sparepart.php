<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    protected $fillable = ['code', 'name', 'category', 'stock', 'min_stock', 'unit', 'price', 'description'];

    public function isLowStock()
    {
        return $this->stock <= $this->min_stock;
    }

    public function tickets()
    {
        return $this->belongsToMany(MaintenanceTicket::class, 'ticket_spareparts')
                    ->withPivot('quantity', 'unit_price', 'total_price')
                    ->withTimestamps();
    }
}
