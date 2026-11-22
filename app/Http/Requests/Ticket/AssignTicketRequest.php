<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AssignTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'AssignedToUserId' => $this->input('AssignedToUserId') ?? $this->input('assignee_id') ?? $this->input('user_id'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'AssignedToUserId' => ['required', 'integer', 'exists:User,UserId'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'AssignedToUserId.required' => 'Vui lòng chọn nhân sự để phân công.',
            'AssignedToUserId.exists' => 'Nhân sự đã chọn không tồn tại.',
        ];
    }
}
