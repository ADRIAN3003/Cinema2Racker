<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A név megadása kötelező.',
            'name.max' => 'A név legfeljebb 100 karakter lehet.',
            'email.required' => 'Az e-mail cím megadása kötelező.',
            'email.email' => 'Adj meg egy érvényes e-mail címet.',
            'email.max' => 'Az e-mail cím legfeljebb 255 karakter lehet.',
            'subject.required' => 'A tárgy megadása kötelező.',
            'subject.max' => 'A tárgy legfeljebb 150 karakter lehet.',
            'message.required' => 'Az üzenet megírása kötelező.',
            'message.min' => 'Az üzenet legalább 10 karakter legyen.',
            'message.max' => 'Az üzenet legfeljebb 2000 karakter lehet.',
        ];
    }
}
