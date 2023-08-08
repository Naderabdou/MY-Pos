<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function langValidation(): array
    {
        $rules = ['category_id' => 'required'];
        foreach (config('translatable.locales') as $locale) {
            $rules += [
                $locale.'.name'=>'re',
                $locale . '.name' => [
                    'required',
                    Rule::unique('product_translations', 'name')->ignore($this->product->id, 'product_id')
                ],
                $locale . '.description' => 'required|string',
            ];

        }
        $rules += [
            'purchase_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'image',
            'sale_price' => 'required|numeric',
        ];
        return $rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return $this->langValidation();
    }
}
