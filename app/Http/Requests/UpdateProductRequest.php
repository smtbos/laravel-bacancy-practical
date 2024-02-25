<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'lots' => 'required|array|min:1',
            'lots.*.quantity' => 'required|integer|min:1',
            'lots.*.expiry_date' => 'required|date|distinct',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'lots.*.quantity.required' => 'The quantity field is required.',
            'lots.*.quantity.integer' => 'The quantity must be an integer.',
            'lots.*.quantity.min' => 'The quantity must be at least 1.',
            'lots.*.expiry_date.required' => 'The expiry date field is required.',
            'lots.*.expiry_date.date' => 'The expiry date must be a date.',
            'lots.*.expiry_date.distinct' => 'The expiry date has already been taken.',
        ];
    }
}
