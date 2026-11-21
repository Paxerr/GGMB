<?php

namespace App\Models;

use Database\Factories\TicketResponseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketResponse extends Model
{
    /** @use HasFactory<TicketResponseFactory> */
    use HasFactory;

    protected $table = 'TicketResponse';

    protected $primaryKey = 'TicketResponseId';

    public $timestamps = false;

    protected $fillable = [
        'TicketId',
        'RespondedByUserId',
        'Content',
        'CreatedAt',
    ];

    protected function casts(): array
    {
        return [
            'CreatedAt' => 'datetime',
        ];
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'TicketId', 'TicketId');
    }

    public function respondedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'RespondedByUserId', 'UserId');
    }
}
