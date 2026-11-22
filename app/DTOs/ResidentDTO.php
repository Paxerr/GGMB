<?php

namespace App\DTOs;

use App\Http\Requests\Resident\StoreResidentRequest;
use App\Http\Requests\Resident\UpdateResidentRequest;

readonly class ResidentDTO
{
    public function __construct(
        public string $fullName,
        public ?string $citizenId,
        public ?string $phone,
        public ?string $email,
        public ?int $apartmentId = null,
        public ?string $startDate = null,
        public ?string $endDate = null,
        public ?string $status = 'ACTIVE',
        public ?string $userName = null,
        public ?string $password = null,
    ) {}

    public static function fromStoreRequest(StoreResidentRequest $request): self
    {
        return new self(
            fullName: trim((string) $request->validated('FullName')),
            citizenId: $request->filled('CitizenId') ? trim((string) $request->validated('CitizenId')) : null,
            phone: $request->filled('Phone') ? trim((string) $request->validated('Phone')) : null,
            email: $request->filled('Email') ? trim((string) $request->validated('Email')) : null,
            apartmentId: $request->filled('ApartmentId') ? (int) $request->validated('ApartmentId') : null,
            startDate: $request->filled('StartDate') ? (string) $request->validated('StartDate') : now()->format('Y-m-d'),
            endDate: $request->filled('EndDate') ? (string) $request->validated('EndDate') : null,
            status: $request->filled('Status') ? (string) $request->validated('Status') : 'ACTIVE',
            userName: $request->filled('UserName') ? trim((string) $request->validated('UserName')) : null,
            password: $request->filled('Password') ? (string) $request->validated('Password') : null,
        );
    }

    public static function fromUpdateRequest(UpdateResidentRequest $request): self
    {
        return new self(
            fullName: trim((string) $request->validated('FullName')),
            citizenId: $request->filled('CitizenId') ? trim((string) $request->validated('CitizenId')) : null,
            phone: $request->filled('Phone') ? trim((string) $request->validated('Phone')) : null,
            email: $request->filled('Email') ? trim((string) $request->validated('Email')) : null,
            apartmentId: $request->filled('ApartmentId') ? (int) $request->validated('ApartmentId') : null,
            startDate: $request->filled('StartDate') ? (string) $request->validated('StartDate') : null,
            endDate: $request->filled('EndDate') ? (string) $request->validated('EndDate') : null,
            status: $request->filled('Status') ? (string) $request->validated('Status') : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toUserArray(): array
    {
        $data = [
            'FullName' => $this->fullName,
            'CitizenId' => $this->citizenId,
            'Phone' => $this->phone,
            'Email' => $this->email,
            'Role' => 'RESIDENT',
            'Status' => $this->status ?? 'ACTIVE',
        ];

        if ($this->userName !== null && $this->userName !== '') {
            $data['UserName'] = $this->userName;
        }

        if ($this->password !== null && $this->password !== '') {
            $data['PasswordHash'] = bcrypt($this->password);
        }

        return $data;
    }
}
