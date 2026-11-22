<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'UserName' => $this->input('UserName') ?? $this->input('username') ?? $this->input('user_name'),
            'FullName' => $this->input('FullName') ?? $this->input('name') ?? $this->input('full_name'),
            'Password' => $this->input('Password') ?? $this->input('password'),
            'Phone' => $this->input('Phone') ?? $this->input('phone'),
            'Email' => $this->input('Email') ?? $this->input('email'),
            'CitizenId' => $this->input('CitizenId') ?? $this->input('citizen_id'),
            'Role' => $this->input('Role') ?? $this->input('role'),
            'Department' => $this->input('Department') ?? $this->input('department'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'UserName' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:User,UserName'],
            'FullName' => ['required', 'string', 'max:100'],
            'Password' => ['required', 'string', 'min:6'],
            'Phone' => ['nullable', 'string', 'max:20'],
            'Email' => ['nullable', 'email', 'max:255'],
            'CitizenId' => ['nullable', 'string', 'max:20'],
            'Role' => ['required', 'string'],
            'Department' => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'UserName.required' => 'Vui lòng nhập tên đăng nhập.',
            'UserName.unique' => 'Tên đăng nhập này đã được sử dụng.',
            'FullName.required' => 'Vui lòng nhập họ và tên.',
            'Password.required' => 'Vui lòng nhập mật khẩu khởi tạo.',
            'Password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'Email.email' => 'Địa chỉ email không đúng định dạng.',
            'Role.required' => 'Vui lòng chọn vai trò tài khoản.',
        ];
    }
}
