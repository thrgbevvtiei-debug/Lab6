<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:500'],
            'text'        => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:category,category_id'],
            'filters'     => ['sometimes', 'array'],
            'filters.*'   => ['integer', 'distinct', 'exists:filter,filter_id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => 'Вкажіть заголовок.',
            'title.max'          => 'Заголовок не може бути довшим за 200 символів.',
            'description.max'    => 'Опис не може бути довшим за 500 символів.',
            'category_id.exists' => 'Обрана категорія не існує.',
            'filters.*.exists'   => 'Обрана мітка не існує.',
            'filters.*.distinct' => 'Мітки не повинні повторюватись.',
        ];
    }
}
