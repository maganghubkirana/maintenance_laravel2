<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

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

    use LogsActivity;

    protected $guarded = ['id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('sparepart')
            ->setDescriptionForEvent(fn(string $eventName) => "Stok/Data sparepart telah di-{$eventName}");
    }
}
