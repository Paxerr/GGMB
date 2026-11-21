<?php

namespace App\Models;

use Database\Factories\FloorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Floor extends Model
{
    /** @use HasFactory<FloorFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'Floor';

    protected $primaryKey = 'FloorId';

    const CREATED_AT = 'CreatedAt';

    const UPDATED_AT = 'UpdatedAt';

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'BuildingId',
        'FloorNumber',
        'IsDeleted',
        'DeletedAt',
    ];

    protected function casts(): array
    {
        return [
            'FloorNumber' => 'integer',
            'IsDeleted' => 'boolean',
            'DeletedAt' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Floor $floor) {
            if (! $floor->isForceDeleting()) {
                $floor->IsDeleted = true;
                $floor->saveQuietly();
            }
        });
        static::restoring(function (Floor $floor) {
            $floor->IsDeleted = false;
            $floor->saveQuietly();
        });
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'BuildingId', 'BuildingId');
    }

    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class, 'FloorId', 'FloorId');
    }
}
