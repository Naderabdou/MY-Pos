<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function langValidation(): array
    {
        $rules=['category_id'=>'required|exists:categories,id'];
        foreach (config('translatable.locales') as $locale){
            $rules+=[
                $locale.'.name'=>'required|string|unique:product_translations,name',
                $locale.'.description'=>'required|string',
            ];

        }
        $rules+=[
            'purchase_price'=>'required|numeric',
            'stock'=>'required|numeric',
            'image'=>'image',
            'sale_price'=>'required|numeric',
        ];
        return $rules;

    }


    public function rules(): array
    {
        return $this->langValidation();
    }
}
