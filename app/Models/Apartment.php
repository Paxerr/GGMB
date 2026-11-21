<?php

namespace App\Models;

use Database\Factories\ApartmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    /** @use HasFactory<ApartmentFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'Apartment';

    protected $primaryKey = 'ApartmentId';

    const CREATED_AT = 'CreatedAt';

    const UPDATED_AT = 'UpdatedAt';

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'FloorId',
        'ApartmentNumber',
        'Status',
        'Description',
        'IsDeleted',
        'DeletedAt',
    ];

    protected function casts(): array
    {
        return [
            'IsDeleted' => 'boolean',
            'DeletedAt' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Apartment $apartment) {
            if (! $apartment->isForceDeleting()) {
                $apartment->IsDeleted = true;
                $apartment->saveQuietly();
            }
        });
        static::restoring(function (Apartment $apartment) {
            $apartment->IsDeleted = false;
            $apartment->saveQuietly();
        });
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class, 'FloorId', 'FloorId');
    }

    public function residents(): HasMany
    {
        return $this->hasMany(ApartmentResident::class, 'ApartmentId', 'ApartmentId');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'ApartmentId', 'ApartmentId');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'ApartmentId', 'ApartmentId');
    }

    public function meterReadings(): HasMany
    {
        return $this->hasMany(MeterReading::class, 'ApartmentId', 'ApartmentId');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'ApartmentId', 'ApartmentId');
    }
}
