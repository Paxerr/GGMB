<?php

namespace App\Http\Requests\Portal;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePortalProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'Phone' => $this->input('Phone') ?? $this->input('phone'),
            'Email' => $this->input('Email') ?? $this->input('email'),
            'Password' => $this->input('Password') ?? $this->input('password'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Phone' => ['nullable', 'string', 'max:20'],
            'Email' => ['nullable', 'email', 'max:255'],
            'Password' => ['nullable', 'string', 'min:6'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'Email.email' => 'Địa chỉ email không đúng định dạng.',
            'Password.min' => 'Mật khẩu phải từ 6 ký tự trở lên.',
        ];
    }
}
