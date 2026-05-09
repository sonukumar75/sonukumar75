<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sample extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'project_id',
        'sample_code',
        'material_type',
        'source_location',
        'received_at',
        'status',
        'remarks',
    ];

    protected function casts(): array
    {
        return ['received_at' => 'datetime'];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(LabTest::class);
    }
}
