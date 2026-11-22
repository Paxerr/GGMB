<?php

namespace App\Http\Requests\Apartment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApartmentRequest extends FormRequest
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
        $apartment = $this->route('apartment');
        $apartmentId = $apartment?->ApartmentId ?? $apartment;
        $floorId = $apartment?->FloorId ?? $this->input('FloorId');

        return [
            'ApartmentNumber' => [
                'required',
                'string',
                'max:20',
                Rule::unique('Apartment', 'ApartmentNumber')
                    ->where(fn ($query) => $query->where('FloorId', $floorId)->where('IsDeleted', false))
                    ->ignore($apartmentId, 'ApartmentId'),
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
            'ApartmentNumber.required' => 'Vui lòng nhập số căn hộ.',
            'ApartmentNumber.unique' => 'Số căn hộ này đã tồn tại trên tầng.',
            'Status.required' => 'Vui lòng chọn trạng thái căn hộ.',
        ];
    }
}
