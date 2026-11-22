<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
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
            'Subject' => ['required', 'string', 'max:200'],
            'Description' => ['required', 'string'],
            'Category' => ['required', 'string', 'max:30'],
        ];
    }
}
