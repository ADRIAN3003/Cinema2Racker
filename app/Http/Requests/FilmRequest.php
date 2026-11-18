<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilmRequest extends FormRequest
{
    public const SZINKRON = [
        'fel' => 'Feliratos',
        'mb' => 'Magyarul beszélő',
        'szöveg nélküli' => 'Szöveg nélküli',
    ];

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'szines' => $this->boolean('szines'),
            'szinkron' => $this->input('szinkron') ?: null,
            'mufaj' => $this->input('mufaj') ?: null,
        ]);
    }

    public function rules(): array
    {
        return [
            'cim' => ['required', 'string', 'max:255'],
            'szines' => ['boolean'],
            'szinkron' => ['nullable', Rule::in(array_keys(self::SZINKRON))],
            'szarmazas' => ['required', 'string', 'max:120'],
            'mufaj' => ['nullable', 'string', 'max:50'],
            'hossz' => ['required', 'integer', 'between:1,600'],
        ];
    }

    public function messages(): array
    {
        return [
            'cim.required' => 'A cím megadása kötelező.',
            'cim.max' => 'A cím legfeljebb 255 karakter lehet.',
            'szinkron.in' => 'Válassz a listából.',
            'szarmazas.required' => 'A származás megadása kötelező.',
            'szarmazas.max' => 'A származás legfeljebb 120 karakter lehet.',
            'mufaj.max' => 'A műfaj legfeljebb 50 karakter lehet.',
            'hossz.required' => 'A hossz megadása kötelező.',
            'hossz.integer' => 'A hossz egész szám legyen (percben).',
            'hossz.between' => 'A hossz 1 és 600 perc között legyen.',
        ];
    }
}
