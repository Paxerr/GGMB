<?php

namespace App\DTOs;

use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;

readonly class TicketDTO
{
    public function __construct(
        public int $createdByUserId,
        public ?int $apartmentId,
        public string $subject,
        public string $description,
        public string $category,
        public string $status = 'WAITING',
    ) {}

    public static function fromStoreRequest(StoreTicketRequest $request, int $userId): self
    {
        return new self(
            createdByUserId: $userId,
            apartmentId: $request->filled('ApartmentId') ? (int) $request->validated('ApartmentId') : null,
            subject: trim((string) $request->validated('Subject')),
            description: trim((string) $request->validated('Description')),
            category: trim((string) $request->validated('Category')),
            status: 'WAITING',
        );
    }

    public static function fromUpdateRequest(UpdateTicketRequest $request, int $existingUserId, ?int $existingAptId): self
    {
        return new self(
            createdByUserId: $existingUserId,
            apartmentId: $existingAptId,
            subject: trim((string) $request->validated('Subject')),
            description: trim((string) $request->validated('Description')),
            category: trim((string) $request->validated('Category')),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toModelArray(): array
    {
        return [
            'CreatedByUserId' => $this->createdByUserId,
            'ApartmentId' => $this->apartmentId,
            'Subject' => $this->subject,
            'Description' => $this->description,
            'Category' => $this->category,
            'Status' => $this->status,
            'CreatedAt' => now(),
        ];
    }
}
