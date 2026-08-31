<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceRequest extends Model
{
    protected $table = 'maintenance_requests';
    protected $fillable = ['equipment_id', 'engineer_id', 'description', 'priority', 'status'];

    public function equipment(): BelongsTo { return $this->belongsTo(Equipment::class, 'equipment_id'); }
    public function engineer(): BelongsTo { return $this->belongsTo(User::class, 'engineer_id'); }
    public function approvals(): HasMany { return $this->hasMany(ApprovalHistory::class, 'maintenance_id'); }
}
