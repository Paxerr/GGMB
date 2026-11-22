<?php

namespace App\Http\Requests\Apartment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApartmentRequest extends FormRequest
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
            'FloorId' => ['required', 'integer', 'exists:Floor,FloorId'],
            'ApartmentNumber' => [
                'required',
                'string',
                'max:20',
                Rule::unique('Apartment', 'ApartmentNumber')
                    ->where(fn ($query) => $query->where('FloorId', $this->FloorId)->where('IsDeleted', false)),
            ],
            'Status' => ['required', 'string', 'in:AVAILABLE,VACANT,OCCUPIED,SUSPENDED,INACTIVE'],
            'Description' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'FloorId.required' => 'Vui lòng chọn tầng.',
            'FloorId.exists' => 'Tầng đã chọn không tồn tại.',
            'ApartmentNumber.required' => 'Vui lòng nhập số căn hộ.',
            'ApartmentNumber.unique' => 'Số căn hộ này đã tồn tại trên tầng đã chọn.',
            'Status.required' => 'Vui lòng chọn trạng thái căn hộ.',
        ];
    }
}
