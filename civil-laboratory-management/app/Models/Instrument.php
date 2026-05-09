<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'asset_code',
        'name',
        'serial_number',
        'manufacturer',
        'location',
        'status',
        'purchase_date',
        'next_calibration_due',
        'maintenance_notes',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'next_calibration_due' => 'date',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function calibrations(): HasMany
    {
        return $this->hasMany(Calibration::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(LabTest::class);
    }
}
