<?php

namespace App\Models;

use Database\Factories\NotificationTargetFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationTarget extends Model
{
    /** @use HasFactory<NotificationTargetFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'NotificationTarget';

    protected $primaryKey = 'NotificationTargetId';

    public $timestamps = false;

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'NotificationId',
        'BuildingId',
        'FloorId',
        'ApartmentId',
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
        static::deleting(function (NotificationTarget $target) {
            if (! $target->isForceDeleting()) {
                $target->IsDeleted = true;
                $target->saveQuietly();
            }
        });
        static::restoring(function (NotificationTarget $target) {
            $target->IsDeleted = false;
            $target->saveQuietly();
        });
    }

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'NotificationId', 'NotificationId');
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'BuildingId', 'BuildingId');
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class, 'FloorId', 'FloorId');
    }

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class, 'ApartmentId', 'ApartmentId');
    }
}
