<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBoxRequest extends FormRequest
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
            "box_number" => ['required', 'string', 'min:1', 'max:10', 'unique:boxes'],
            "box_date" => ['required', 'string', 'date'],
        ];
    }
}
