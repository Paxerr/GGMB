<?php

namespace App\Models;

use Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    /** @use HasFactory<InvoiceFactory> */
    use HasFactory;

    protected $table = 'Invoice';

    protected $primaryKey = 'InvoiceId';

    const CREATED_AT = 'CreatedAt';

    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'ApartmentId',
        'BillingPeriod',
        'TotalAmount',
        'DueDate',
        'Status',
        'PaymentType',
        'PaidAt',
        'CreatedByUserId',
    ];

    protected function casts(): array
    {
        return [
            'TotalAmount' => 'decimal:2',
            'DueDate' => 'date',
            'PaidAt' => 'datetime',
        ];
    }

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class, 'ApartmentId', 'ApartmentId');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'CreatedByUserId', 'UserId');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'InvoiceId', 'InvoiceId');
    }
}
