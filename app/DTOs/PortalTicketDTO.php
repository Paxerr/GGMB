<?php

namespace App\DTOs;

use App\Http\Requests\Portal\StorePortalTicketRequest;

readonly class PortalTicketDTO
{
    public function __construct(
        public int $userId,
        public ?int $apartmentId,
        public string $subject,
        public string $description,
        public string $category,
    ) {}

    public static function fromRequest(StorePortalTicketRequest $request, int $userId, ?int $apartmentId): self
    {
        return new self(
            userId: $userId,
            apartmentId: $apartmentId,
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
            'CreatedByUserId' => $this->userId,
            'ApartmentId' => $this->apartmentId,
            'Subject' => $this->subject,
            'Description' => $this->description,
            'Category' => $this->category,
            'Status' => 'WAITING',
            'CreatedAt' => now(),
        ];
    }
}
