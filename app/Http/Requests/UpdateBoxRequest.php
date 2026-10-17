<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBoxRequest extends FormRequest
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
            "box_name" => ['required', 'string', 'min:1', 'max:255'],
            "box_number" => ['sometimes', 'required', 'string', 'min:1', 'max:10'],
            "box_date" => ['required', 'string', 'date'],
        ];
    }
}
