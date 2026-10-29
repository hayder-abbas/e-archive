<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAuditLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
            'name' => ['reqired', 'string', 'max:50'],
            'action' => ['reqired', 'string', Rule::in(['add', 'edit', 'revoke', 'reinstate', 'delete'])],
            'type' => ['reqired', Rule::in(['document', 'box', 'entity', 'borrow'])],
            'number' => ['reqired', 'string', 'max:50'],
        ];
    }
}
