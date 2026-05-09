<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calibration extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'instrument_id',
        'calibrated_on',
        'due_on',
        'certificate_number',
        'agency_name',
        'result',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'calibrated_on' => 'date',
            'due_on' => 'date',
        ];
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }
}
