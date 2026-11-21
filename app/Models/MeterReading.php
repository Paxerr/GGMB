<?php

namespace App\Models;

use Database\Factories\MeterReadingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeterReading extends Model
{
    /** @use HasFactory<MeterReadingFactory> */
    use HasFactory;

    protected $table = 'MeterReading';

    protected $primaryKey = 'MeterReadingId';

    public $timestamps = false;

    protected $fillable = [
        'ApartmentId',
        'FeeTypeId',
        'RecordedByUserId',
        'BillingPeriod',
        'PreviousReading',
        'CurrentReading',
        'Consumption',
        'RecordedAt',
    ];

    protected function casts(): array
    {
        return [
            'PreviousReading' => 'decimal:3',
            'CurrentReading' => 'decimal:3',
            'Consumption' => 'decimal:3',
            'RecordedAt' => 'datetime',
        ];
    }

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class, 'ApartmentId', 'ApartmentId');
    }

    public function feeType(): BelongsTo
    {
        return $this->belongsTo(FeeType::class, 'FeeTypeId', 'FeeTypeId');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'RecordedByUserId', 'UserId');
    }
}
