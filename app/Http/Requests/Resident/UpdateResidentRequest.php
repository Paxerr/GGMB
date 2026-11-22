<?php

namespace App\Http\Requests\Resident;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResidentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'FullName' => $this->input('FullName') ?? $this->input('full_name'),
            'CitizenId' => $this->input('CitizenId') ?? $this->input('citizen_id'),
            'Phone' => $this->input('Phone') ?? $this->input('phone'),
            'Email' => $this->input('Email') ?? $this->input('email'),
            'ApartmentId' => $this->input('ApartmentId') ?? $this->input('apartment_id'),
            'StartDate' => $this->input('StartDate') ?? $this->input('start_date'),
            'EndDate' => $this->input('EndDate') ?? $this->input('end_date'),
            'Status' => $this->input('Status') ?? $this->input('status'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'FullName' => ['required', 'string', 'max:100'],
            'CitizenId' => ['nullable', 'string', 'max:20'],
            'Phone' => ['nullable', 'string', 'max:20'],
            'Email' => ['nullable', 'email', 'max:255'],
            'ApartmentId' => ['nullable', 'integer', 'exists:Apartment,ApartmentId'],
            'StartDate' => ['nullable', 'date'],
            'EndDate' => ['nullable', 'date', 'after_or_equal:StartDate'],
            'Status' => ['nullable', 'string', 'in:ACTIVE,INACTIVE'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'FullName.required' => 'Vui lòng nhập họ tên cư dân.',
            'ApartmentId.exists' => 'Căn hộ đã chọn không tồn tại.',
            'Email.email' => 'Địa chỉ email không đúng định dạng.',
        ];
    }
}
