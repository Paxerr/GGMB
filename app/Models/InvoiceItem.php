<?php

namespace App\Models;

use Database\Factories\InvoiceItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    /** @use HasFactory<InvoiceItemFactory> */
    use HasFactory;

    protected $table = 'InvoiceItem';

    protected $primaryKey = 'InvoiceItemId';

    public $timestamps = false;

    protected $fillable = [
        'InvoiceId',
        'FeeTypeId',
        'FeeRateId',
        'Quantity',
        'UnitPrice',
        'Amount',
    ];

    protected function casts(): array
    {
        return [
            'Quantity' => 'decimal:3',
            'UnitPrice' => 'decimal:2',
            'Amount' => 'decimal:2',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'InvoiceId', 'InvoiceId');
    }

    public function feeType(): BelongsTo
    {
        return $this->belongsTo(FeeType::class, 'FeeTypeId', 'FeeTypeId');
    }

    public function feeRate(): BelongsTo
    {
        return $this->belongsTo(FeeRate::class, 'FeeRateId', 'FeeRateId');
    }
}
