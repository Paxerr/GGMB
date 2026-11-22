<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ApartmentId' => $this->input('ApartmentId') ?? $this->input('apartment_id'),
            'Subject' => $this->input('Subject') ?? $this->input('title') ?? $this->input('subject'),
            'Description' => $this->input('Description') ?? $this->input('description'),
            'Category' => $this->input('Category') ?? $this->input('category'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ApartmentId' => ['nullable', 'integer', 'exists:Apartment,ApartmentId'],
            'Subject' => ['required', 'string', 'max:200'],
            'Description' => ['required', 'string'],
            'Category' => ['required', 'string', 'max:30'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'Subject.required' => 'Vui lòng nhập tiêu đề yêu cầu.',
            'Description.required' => 'Vui lòng nhập nội dung chi tiết yêu cầu.',
            'Category.required' => 'Vui lòng chọn danh mục yêu cầu.',
        ];
    }
}
