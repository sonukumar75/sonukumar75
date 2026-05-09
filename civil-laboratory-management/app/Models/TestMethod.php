<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'standard_code',
        'material_type',
        'turnaround_hours',
        'unit_rate',
        'acceptance_criteria',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'turnaround_hours' => 'integer',
            'unit_rate' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(LabTest::class);
    }
}
