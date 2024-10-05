<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
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
        $categoryId = $this->route('category');
        return [
            'name' => [
                'sometimes',
                'string',
                'max:155',
                // Ignoriert den aktuellen Namen, wenn er nicht geändert wird
                Rule::unique('categories')->ignore($categoryId)
            ],
            'description' => 'nullable'
        ];
    }
}
