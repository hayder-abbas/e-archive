<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBorrowRequest extends FormRequest
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
            'lender' => ['required', 'string', 'max:255'],
            'borrower' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:50', 'exists:documents,number'],
            'date' => ['required', 'date'],
        ];
    }
}
