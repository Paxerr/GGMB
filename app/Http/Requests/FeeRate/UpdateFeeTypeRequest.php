<?php

namespace App\Http\Requests\FeeRate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFeeTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'Name' => $this->input('Name') ?? $this->input('name'),
            'Description' => $this->input('Description') ?? $this->input('description'),
            'IsActive' => $this->input('IsActive') ?? $this->input('is_active'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Name' => ['required', 'string', 'max:100'],
            'Description' => ['nullable', 'string', 'max:500'],
            'IsActive' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'Name.required' => 'Vui lòng nhập tên loại phí.',
        ];
    }
}
