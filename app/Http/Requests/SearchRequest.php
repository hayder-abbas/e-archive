<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
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
            'name'       => ['nullable', 'string', 'max:255'],
            'number'     => ['nullable', 'string', 'max:50'],
            'fromDate'   => ['nullable', 'date_format:Y-m-d'],
            'toDate'     => ['nullable', 'date_format:Y-m-d', 'after_or_equal:fromDate'],
            'typeFilter' => ['nullable', Rule::in(['all', 'Incoming', 'Outgoing'])],
            'revoked_at' => ['nullable', 'date_format:Y-m-d']
        ];
    }
}
