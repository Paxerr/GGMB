<?php

namespace App\DTOs;

use App\Http\Requests\Tech\CompleteTaskRequest;

readonly class TechTaskDTO
{
    public function __construct(
        public int $ticketId,
        public int $technicianUserId,
        public string $status,
        public ?string $content = null,
    ) {}

    public static function fromRequest(CompleteTaskRequest $request, int $ticketId, int $techId): self
    {
        return new self(
            ticketId: $ticketId,
            technicianUserId: $techId,
            status: $request->validated('status') ?? 'RESOLVED',
            content: $request->filled('content') ? trim((string) $request->validated('content')) : 'Đã xử lý xong yêu cầu tại hiện trường.',
        );
    }
}
