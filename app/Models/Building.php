<?php

namespace App\Models;

use Database\Factories\BuildingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    /** @use HasFactory<BuildingFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'Building';

    protected $primaryKey = 'BuildingId';

    const CREATED_AT = 'CreatedAt';

    const UPDATED_AT = 'UpdatedAt';

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'BuildingName',
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
        static::deleting(function (Building $building) {
            if (! $building->isForceDeleting()) {
                $building->IsDeleted = true;
                $building->saveQuietly();
            }
        });
        static::restoring(function (Building $building) {
            $building->IsDeleted = false;
            $building->saveQuietly();
        });
    }

    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class, 'BuildingId', 'BuildingId');
    }
}
