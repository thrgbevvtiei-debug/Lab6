<?php

namespace App\Http\Requests;

use App\Enums\FuelType;
use App\Enums\Transmission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand'        => ['required', 'string', 'max:50'],
            'model'        => ['required', 'string', 'max:50'],
            'year'         => ['required', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'price'        => ['required', 'numeric', 'min:0'],
            'mileage'      => ['required', 'integer', 'min:0'],
            'fuel_type'    => ['required', Rule::enum(FuelType::class)],
            'transmission' => ['required', Rule::enum(Transmission::class)],
            'color'        => ['nullable', 'string', 'max:30'],
            'features'     => ['sometimes', 'array'],
            'features.*'   => ['integer', 'distinct', 'exists:features,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'features.*.exists'   => 'Обрана опція не існує.',
            'features.*.distinct' => 'Опції не повинні повторюватись.',
        ];
    }
}
