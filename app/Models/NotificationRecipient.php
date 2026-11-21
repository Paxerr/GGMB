<?php

namespace App\Models;

use Database\Factories\NotificationRecipientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationRecipient extends Model
{
    /** @use HasFactory<NotificationRecipientFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'NotificationRecipient';

    protected $primaryKey = 'NotificationRecipientId';

    public $timestamps = false;

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'NotificationId',
        'UserId',
        'IsRead',
        'IsDeleted',
        'DeletedAt',
    ];

    protected function casts(): array
    {
        return [
            'IsRead' => 'boolean',
            'IsDeleted' => 'boolean',
            'DeletedAt' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (NotificationRecipient $recipient) {
            if (! $recipient->isForceDeleting()) {
                $recipient->IsDeleted = true;
                $recipient->saveQuietly();
            }
        });
        static::restoring(function (NotificationRecipient $recipient) {
            $recipient->IsDeleted = false;
            $recipient->saveQuietly();
        });
    }

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'NotificationId', 'NotificationId');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserId', 'UserId');
    }
}
