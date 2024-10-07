<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('customers')->ignore($this->route('customer')),
            ],
            'phone' => ['required', 'regex:/^\(\d{2}\) (9?\d{4})-\d{4}$/'],
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'address_extra' => 'nullable|string|max:255',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'The phone number format is invalid. It should be like (XX) XXXX-XXXX or (XX) 9XXXX-XXXX.'
        ];
    }
}
