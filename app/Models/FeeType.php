<?php

namespace App\Models;

use Database\Factories\FeeTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeType extends Model
{
    /** @use HasFactory<FeeTypeFactory> */
    use HasFactory;

    protected $table = 'FeeType';

    protected $primaryKey = 'FeeTypeId';

    const CREATED_AT = 'CreatedAt';

    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'Code',
        'Name',
        'Description',
        'IsActive',
    ];

    protected function casts(): array
    {
        return [
            'IsActive' => 'boolean',
        ];
    }

    public function rates(): HasMany
    {
        return $this->hasMany(FeeRate::class, 'FeeTypeId', 'FeeTypeId');
    }

    public function meterReadings(): HasMany
    {
        return $this->hasMany(MeterReading::class, 'FeeTypeId', 'FeeTypeId');
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'FeeTypeId', 'FeeTypeId');
    }
}
