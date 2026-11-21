<?php

namespace App\Models;

use Database\Factories\TicketAssignmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAssignment extends Model
{
    /** @use HasFactory<TicketAssignmentFactory> */
    use HasFactory;

    protected $table = 'TicketAssignment';

    protected $primaryKey = 'TicketAssignmentId';

    public $timestamps = false;

    protected $fillable = [
        'TicketId',
        'AssignedToUserId',
        'AssignedAt',
    ];

    protected function casts(): array
    {
        return [
            'AssignedAt' => 'datetime',
        ];
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'TicketId', 'TicketId');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'AssignedToUserId', 'UserId');
    }
}
