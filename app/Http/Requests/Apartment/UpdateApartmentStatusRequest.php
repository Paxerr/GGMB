<?php

namespace App\Http\Requests\Apartment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Status' => ['required', 'string', 'in:AVAILABLE,VACANT,OCCUPIED,SUSPENDED,INACTIVE'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'Status.required' => 'Vui lòng chọn trạng thái mới cho căn hộ.',
            'Status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}
