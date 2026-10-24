<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreDocumentRequest extends FormRequest
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
            'number' => ['required', 'string', 'min:1', 'max:50'],
            'date' => ['required', 'date'],
            'subject' => ['required', 'string', 'min:1', 'max:255'],
            'type' => ['required', 'string'],
            'security' => ['required', 'string'],
            'belongs_to' => ['nullable', 'string', 'min:1', 'max:50', 'exists:documents'],
            'file' => ['nullable', File::types('pdf')->max(20 * 1024)],
            'notes' => ['nullable', 'string'],
            'box_id' => ['required', 'exists:boxes,id'],
            'entity_id' => ['required', 'exists:entities,id'],
        ];
    }
}
