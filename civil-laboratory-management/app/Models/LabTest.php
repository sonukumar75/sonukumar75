<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'sample_id',
        'test_method_id',
        'instrument_id',
        'assigned_to',
        'scheduled_at',
        'completed_at',
        'result_value',
        'result_unit',
        'status',
        'review_notes',
        'approved_by',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'completed_at' => 'datetime',
            'result_value' => 'decimal:4',
        ];
    }

    public function sample(): BelongsTo
    {
        return $this->belongsTo(Sample::class);
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(TestMethod::class, 'test_method_id');
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
