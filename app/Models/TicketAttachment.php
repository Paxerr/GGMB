<?php

namespace App\Models;

use Database\Factories\TicketAttachmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketAttachment extends Model
{
    /** @use HasFactory<TicketAttachmentFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'TicketAttachment';

    protected $primaryKey = 'TicketAttachmentId';

    public $timestamps = false;

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'TicketId',
        'FileName',
        'FilePath',
        'ContentType',
        'FileSize',
        'UploadedByUserId',
        'UploadedAt',
        'IsDeleted',
        'DeletedAt',
    ];

    protected function casts(): array
    {
        return [
            'FileSize' => 'integer',
            'UploadedAt' => 'datetime',
            'IsDeleted' => 'boolean',
            'DeletedAt' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (TicketAttachment $attachment) {
            if (! $attachment->isForceDeleting()) {
                $attachment->IsDeleted = true;
                $attachment->saveQuietly();
            }
        });
        static::restoring(function (TicketAttachment $attachment) {
            $attachment->IsDeleted = false;
            $attachment->saveQuietly();
        });
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'TicketId', 'TicketId');
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UploadedByUserId', 'UserId');
    }
}
