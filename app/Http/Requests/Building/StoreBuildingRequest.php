<?php

namespace App\Http\Requests\Building;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBuildingRequest extends FormRequest
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
            'BuildingName' => ['required', 'string', 'max:100', 'unique:Building,BuildingName'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'BuildingName.required' => 'Vui lòng nhập tên tòa nhà.',
            'BuildingName.unique' => 'Tên tòa nhà này đã tồn tại.',
            'BuildingName.max' => 'Tên tòa nhà không được vượt quá 100 ký tự.',
        ];
    }
}
