<?php

namespace App\DTOs;

use App\Http\Requests\Account\StoreAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;

readonly class AccountDTO
{
    public function __construct(
        public string $userName,
        public string $fullName,
        public ?string $phone,
        public ?string $email,
        public ?string $citizenId,
        public string $role,
        public ?string $department,
        public ?string $password = null,
        public ?string $status = 'ACTIVE',
    ) {}

    public static function fromStoreRequest(StoreAccountRequest $request): self
    {
        $roleInput = (string) $request->validated('Role');
        $normalizedRole = match ($roleInput) {
            'Quản lý' => 'MANAGER',
            'Hỗ trợ' => 'SUPPORT',
            'Kỹ thuật' => 'TECHNICIAN',
            'Bảo vệ' => 'SECURITY',
            default => strtoupper($roleInput),
        };

        return new self(
            userName: trim((string) $request->validated('UserName')),
            fullName: trim((string) $request->validated('FullName')),
            phone: $request->filled('Phone') ? trim((string) $request->validated('Phone')) : null,
            email: $request->filled('Email') ? trim((string) $request->validated('Email')) : null,
            citizenId: $request->filled('CitizenId') ? trim((string) $request->validated('CitizenId')) : null,
            role: $normalizedRole,
            department: $request->filled('Department') ? trim((string) $request->validated('Department')) : null,
            password: (string) $request->validated('Password'),
            status: 'ACTIVE',
        );
    }

    public static function fromUpdateRequest(UpdateAccountRequest $request, string $existingUserName): self
    {
        $roleInput = $request->filled('Role') ? (string) $request->validated('Role') : null;
        $normalizedRole = $roleInput ? match ($roleInput) {
            'Quản lý' => 'MANAGER',
            'Hỗ trợ' => 'SUPPORT',
            'Kỹ thuật' => 'TECHNICIAN',
            'Bảo vệ' => 'SECURITY',
            default => strtoupper($roleInput),
        } : 'SUPPORT';

        return new self(
            userName: $existingUserName,
            fullName: trim((string) $request->validated('FullName')),
            phone: $request->filled('Phone') ? trim((string) $request->validated('Phone')) : null,
            email: $request->filled('Email') ? trim((string) $request->validated('Email')) : null,
            citizenId: $request->filled('CitizenId') ? trim((string) $request->validated('CitizenId')) : null,
            role: $normalizedRole,
            department: $request->filled('Department') ? trim((string) $request->validated('Department')) : null,
            password: $request->filled('Password') ? (string) $request->validated('Password') : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toModelArray(): array
    {
        $data = [
            'UserName' => $this->userName,
            'FullName' => $this->fullName,
            'Phone' => $this->phone,
            'Email' => $this->email,
            'CitizenId' => $this->citizenId,
            'Role' => $this->role,
            'Department' => $this->department,
        ];

        if ($this->password !== null && $this->password !== '') {
            $data['PasswordHash'] = bcrypt($this->password);
        }

        if ($this->status !== null) {
            $data['Status'] = $this->status;
        }

        return $data;
    }
}
