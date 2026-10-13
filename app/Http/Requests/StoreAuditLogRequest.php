<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAuditLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'exists:users'],
            'username' => ['reqired', 'string', 'min:1', 'max:50'],
            'action' => ['reqired', 'string', 'min:1', 'max:20'],
            'target_type' => ['reqired', 'string', 'min:1', 'max:20'],
            'target_number' => ['reqired', 'string', 'min:1', 'max:20'],
        ];
    }
}
