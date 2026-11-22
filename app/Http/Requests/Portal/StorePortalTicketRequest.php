<?php

namespace App\Http\Requests\Portal;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePortalTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'Subject' => $this->input('Subject') ?? $this->input('title') ?? $this->input('subject'),
            'Description' => $this->input('Description') ?? $this->input('content') ?? $this->input('description'),
            'Category' => $this->input('Category') ?? $this->input('category') ?? 'Kỹ thuật',
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Subject' => ['required', 'string', 'max:200'],
            'Description' => ['required', 'string'],
            'Category' => ['required', 'string', 'max:50'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'Subject.required' => 'Vui lòng nhập tiêu đề yêu cầu.',
            'Description.required' => 'Vui lòng nhập chi tiết phản ánh.',
        ];
    }
}
