<?php

namespace App\Http\Requests\Umkm;

use Illuminate\Foundation\Http\FormRequest;

class AiCaptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:caption,content_idea,description,promotion_strategy'],
            'product_name' => ['nullable', 'string', 'max:255', 'required_if:type,caption,description'],
            'description' => ['nullable', 'string', 'max:1000'],
            'target_customer' => ['nullable', 'string', 'max:255'],
            'business_type' => ['nullable', 'string', 'max:255', 'required_if:type,content_idea,promotion_strategy'],
            'keywords' => ['nullable', 'string', 'max:255'],
        ];
    }
}
