<?php

namespace App\Models;

use Database\Factories\ApartmentResidentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApartmentResident extends Model
{
    /** @use HasFactory<ApartmentResidentFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'ApartmentResident';

    protected $primaryKey = 'ApartmentResidentId';

    const CREATED_AT = 'CreatedAt';

    const UPDATED_AT = 'UpdatedAt';

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'ApartmentId',
        'UserId',
        'StartDate',
        'EndDate',
        'Status',
        'IsDeleted',
        'DeletedAt',
    ];

    protected function casts(): array
    {
        return [
            'StartDate' => 'date',
            'EndDate' => 'date',
            'IsDeleted' => 'boolean',
            'DeletedAt' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (ApartmentResident $resident) {
            if (! $resident->isForceDeleting()) {
                $resident->IsDeleted = true;
                $resident->saveQuietly();
            }
        });
        static::restoring(function (ApartmentResident $resident) {
            $resident->IsDeleted = false;
            $resident->saveQuietly();
        });
    }

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class, 'ApartmentId', 'ApartmentId');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserId', 'UserId');
    }
}
