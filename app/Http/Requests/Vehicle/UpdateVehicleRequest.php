<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ApartmentId' => $this->input('ApartmentId') ?? $this->input('apartment_id'),
            'LicensePlate' => $this->input('LicensePlate') ?? $this->input('license_plate'),
            'VehicleType' => $this->input('VehicleType') ?? $this->input('vehicle_type'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ApartmentId' => ['required', 'integer', 'exists:Apartment,ApartmentId'],
            'LicensePlate' => ['required', 'string', 'max:20'],
            'VehicleType' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ApartmentId.required' => 'Vui lòng chọn căn hộ đăng ký phương tiện.',
            'ApartmentId.exists' => 'Căn hộ đã chọn không tồn tại.',
            'LicensePlate.required' => 'Vui lòng nhập biển số xe.',
            'VehicleType.required' => 'Vui lòng chọn loại xe.',
        ];
    }
}
