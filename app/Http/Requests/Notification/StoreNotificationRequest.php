<?php

namespace App\Http\Requests\Notification;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'Title' => $this->input('Title') ?? $this->input('title'),
            'Content' => $this->input('Content') ?? $this->input('body') ?? $this->input('content'),
            'TargetType' => $this->input('TargetType') ?? $this->input('scope') ?? $this->input('target_type') ?? 'ALL',
            'BuildingId' => $this->input('BuildingId') ?? $this->input('building_id'),
            'FloorId' => $this->input('FloorId') ?? $this->input('floor_id'),
            'ApartmentId' => $this->input('ApartmentId') ?? $this->input('apartment_id'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Title' => ['required', 'string', 'max:200'],
            'Content' => ['required', 'string'],
            'TargetType' => ['required', 'string', 'in:ALL,BUILDING,FLOOR,APARTMENT,Tất cả,Tòa nhà,Tầng,Căn hộ'],
            'BuildingId' => ['nullable', 'integer', 'exists:Building,BuildingId'],
            'FloorId' => ['nullable', 'integer', 'exists:Floor,FloorId'],
            'ApartmentId' => ['nullable', 'integer', 'exists:Apartment,ApartmentId'],
            'apartment_ids' => ['nullable', 'array'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'Title.required' => 'Vui lòng nhập tiêu đề thông báo.',
            'Content.required' => 'Vui lòng nhập nội dung thông báo.',
            'TargetType.required' => 'Vui lòng chọn phạm vi gửi thông báo.',
        ];
    }
}
