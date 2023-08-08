<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'first_name' => ['required','string', 'max:255', 'min:3'],
            'last_name' => ['required','string', 'max:255', 'min:3'],
            'email' => ['required', Rule::unique('users')->ignore($this->user)],
           // 'password' => ['string', 'min:8', 'confirmed'],
            'permissions' => ['required','min:1'],
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
