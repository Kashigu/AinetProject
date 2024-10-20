<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerControllerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'photo_url' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nif' => 'nullable|string',
            'address' => 'nullable|string',
        ];
    }
}
