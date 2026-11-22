<?php

namespace App\DTOs;

use App\Http\Requests\Portal\UpdatePortalProfileRequest;

readonly class PortalProfileDTO
{
    public function __construct(
        public ?string $phone,
        public ?string $email,
        public ?string $password = null,
    ) {}

    public static function fromRequest(UpdatePortalProfileRequest $request): self
    {
        return new self(
            phone: $request->filled('Phone') ? trim((string) $request->validated('Phone')) : null,
            email: $request->filled('Email') ? trim((string) $request->validated('Email')) : null,
            password: $request->filled('Password') ? (string) $request->validated('Password') : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toModelArray(): array
    {
        $data = [];
        if ($this->phone !== null) {
            $data['Phone'] = $this->phone;
        }
        if ($this->email !== null) {
            $data['Email'] = $this->email;
        }
        if ($this->password !== null && $this->password !== '') {
            $data['PasswordHash'] = bcrypt($this->password);
        }

        return $data;
    }
}
