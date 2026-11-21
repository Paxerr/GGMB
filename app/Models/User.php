<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'User';

    protected $primaryKey = 'UserId';

    const CREATED_AT = 'CreatedAt';

    const UPDATED_AT = 'UpdatedAt';

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'UserName',
        'PasswordHash',
        'FullName',
        'Phone',
        'Email',
        'CitizenId',
        'Role',
        'Department',
        'Status',
        'remember_token',
        'IsDeleted',
        'DeletedAt',
    ];

    protected $hidden = [
        'PasswordHash',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'PasswordHash' => 'hashed',
            'IsDeleted' => 'boolean',
            'DeletedAt' => 'datetime',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'PasswordHash';
    }

    public function getAuthIdentifierName(): string
    {
        return 'UserId';
    }

    protected static function booted(): void
    {
        static::deleting(function (User $user) {
            if (! $user->isForceDeleting()) {
                $user->IsDeleted = true;
                $user->saveQuietly();
            }
        });
        static::restoring(function (User $user) {
            $user->IsDeleted = false;
            $user->saveQuietly();
        });
    }

    public function apartmentResidents(): HasMany
    {
        return $this->hasMany(ApartmentResident::class, 'UserId', 'UserId');
    }

    public function createdTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'CreatedByUserId', 'UserId');
    }

    public function ticketResponses(): HasMany
    {
        return $this->hasMany(TicketResponse::class, 'RespondedByUserId', 'UserId');
    }

    public function ticketAssignments(): HasMany
    {
        return $this->hasMany(TicketAssignment::class, 'AssignedToUserId', 'UserId');
    }

    public function notificationRecipients(): HasMany
    {
        return $this->hasMany(NotificationRecipient::class, 'UserId', 'UserId');
    }
}
