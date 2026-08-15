<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'recipient_name' => ['required', 'string', 'max:255'],
            'recipient_phone' => ['required', 'string', 'max:20'],
            'delivery_note' => ['nullable', 'string', 'max:500'],
            'fulfillment_method' => ['required', 'in:delivery,pickup'],
        ];

        if ($this->input('fulfillment_method') === 'delivery') {
            $rules['address'] = ['required', 'string', 'max:500'];
            $rules['latitude'] = ['required', 'numeric', 'between:-90,90'];
            $rules['longitude'] = ['required', 'numeric', 'between:-180,180'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'latitude.required' => 'Silakan pilih lokasi pengantaran menggunakan tombol lokasi GPS.',
            'longitude.required' => 'Silakan pilih lokasi pengantaran menggunakan tombol lokasi GPS.',
            'address.required' => 'Alamat pengantaran wajib diisi.',
        ];
    }
}
