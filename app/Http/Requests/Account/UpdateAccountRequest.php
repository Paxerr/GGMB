<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'FullName' => $this->input('FullName') ?? $this->input('name') ?? $this->input('full_name'),
            'Phone' => $this->input('Phone') ?? $this->input('phone'),
            'Email' => $this->input('Email') ?? $this->input('email'),
            'CitizenId' => $this->input('CitizenId') ?? $this->input('citizen_id'),
            'Role' => $this->input('Role') ?? $this->input('role'),
            'Department' => $this->input('Department') ?? $this->input('department'),
            'Password' => $this->input('Password') ?? $this->input('password'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'FullName' => ['required', 'string', 'max:100'],
            'Phone' => ['nullable', 'string', 'max:20'],
            'Email' => ['nullable', 'email', 'max:255'],
            'CitizenId' => ['nullable', 'string', 'max:20'],
            'Role' => ['nullable', 'string'],
            'Department' => ['nullable', 'string', 'max:100'],
            'Password' => ['nullable', 'string', 'min:6'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'FullName.required' => 'Vui lòng nhập họ và tên.',
            'Password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'Email.email' => 'Địa chỉ email không đúng định dạng.',
        ];
    }
}
