<?php

namespace App\Models;

use Database\Factories\NotificationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    /** @use HasFactory<NotificationFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'Notification';

    protected $primaryKey = 'NotificationId';

    public $timestamps = false;

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'CreatedByUserId',
        'Title',
        'Content',
        'TargetType',
        'CreatedAt',
        'IsDeleted',
        'DeletedAt',
    ];

    protected function casts(): array
    {
        return [
            'CreatedAt' => 'datetime',
            'IsDeleted' => 'boolean',
            'DeletedAt' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Notification $notification) {
            if (! $notification->isForceDeleting()) {
                $notification->IsDeleted = true;
                $notification->saveQuietly();
            }
        });
        static::restoring(function (Notification $notification) {
            $notification->IsDeleted = false;
            $notification->saveQuietly();
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'CreatedByUserId', 'UserId');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(NotificationRecipient::class, 'NotificationId', 'NotificationId');
    }

    public function targets(): HasMany
    {
        return $this->hasMany(NotificationTarget::class, 'NotificationId', 'NotificationId');
    }
}
