<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBorrowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'lender' => ['required', 'string', 'min:2', 'max:255'],
            'borrower' => ['required', 'string', 'min:2', 'max:255'],
            'doc_number' => ['required', 'string', 'min:1', 'max:10'],
            'date' => ['required', 'date'],
        ];
    }
}
