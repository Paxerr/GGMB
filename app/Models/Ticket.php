<?php

namespace App\Models;

use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    /** @use HasFactory<TicketFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'Ticket';

    protected $primaryKey = 'TicketId';

    const CREATED_AT = 'CreatedAt';

    const UPDATED_AT = 'UpdatedAt';

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'CreatedByUserId',
        'ApartmentId',
        'Subject',
        'Description',
        'Status',
        'Category',
        'ResolvedAt',
        'IsDeleted',
        'DeletedAt',
    ];

    protected function casts(): array
    {
        return [
            'ResolvedAt' => 'datetime',
            'IsDeleted' => 'boolean',
            'DeletedAt' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Ticket $ticket) {
            if (! $ticket->isForceDeleting()) {
                $ticket->IsDeleted = true;
                $ticket->saveQuietly();
            }
        });
        static::restoring(function (Ticket $ticket) {
            $ticket->IsDeleted = false;
            $ticket->saveQuietly();
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'CreatedByUserId', 'UserId');
    }

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class, 'ApartmentId', 'ApartmentId');
    }

    public function assignment(): HasOne
    {
        return $this->hasOne(TicketAssignment::class, 'TicketId', 'TicketId');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(TicketResponse::class, 'TicketId', 'TicketId');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class, 'TicketId', 'TicketId');
    }
}
