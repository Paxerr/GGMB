<?php

namespace App\Models;

use Database\Factories\FeeRateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeRate extends Model
{
    /** @use HasFactory<FeeRateFactory> */
    use HasFactory;

    protected $table = 'FeeRate';

    protected $primaryKey = 'FeeRateId';

    public $timestamps = false;

    protected $fillable = [
        'FeeTypeId',
        'UnitPrice',
        'EffectiveFrom',
        'EffectiveTo',
        'CreatedAt',
    ];

    protected function casts(): array
    {
        return [
            'UnitPrice' => 'decimal:2',
            'EffectiveFrom' => 'date',
            'EffectiveTo' => 'date',
            'CreatedAt' => 'datetime',
        ];
    }

    public function feeType(): BelongsTo
    {
        return $this->belongsTo(FeeType::class, 'FeeTypeId', 'FeeTypeId');
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'FeeRateId', 'FeeRateId');
    }
}
