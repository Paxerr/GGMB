<?php

namespace App\Models;

use Database\Factories\VehicleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    /** @use HasFactory<VehicleFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'Vehicle';

    protected $primaryKey = 'VehicleId';

    const CREATED_AT = 'CreatedAt';

    const UPDATED_AT = 'UpdatedAt';

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'ApartmentId',
        'LicensePlate',
        'VehicleType',
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
        static::deleting(function (Vehicle $vehicle) {
            if (! $vehicle->isForceDeleting()) {
                $vehicle->IsDeleted = true;
                $vehicle->saveQuietly();
            }
        });
        static::restoring(function (Vehicle $vehicle) {
            $vehicle->IsDeleted = false;
            $vehicle->saveQuietly();
        });
    }

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class, 'ApartmentId', 'ApartmentId');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->VehicleType) {
            'CAR' => 'Xe ô tô',
            'MOTORBIKE' => 'Xe máy',
            'ELECTRIC_BIKE' => 'Xe máy điện',
            'BICYCLE' => 'Xe đạp',
            default => $this->VehicleType ?? '',
        };
    }
}
