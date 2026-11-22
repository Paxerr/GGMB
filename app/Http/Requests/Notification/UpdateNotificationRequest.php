<?php

namespace App\Http\Requests\Notification;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
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
        ];
    }
}
