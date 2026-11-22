<?php

namespace App\Http\Requests\Tech;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompleteTaskRequest extends FormRequest
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
            'content' => ['nullable', 'string', 'max:1000'],
            'status' => ['nullable', 'string', 'in:RESOLVED,PROCESSING'],
        ];
    }
}
