<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanFilterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'with_trainer' => 'nullable|boolean',
            'plan_type' => 'nullable|exists:plan_types,id',
            'entries_number' => 'nullable|integer|min:5',
        ];
    }
}
