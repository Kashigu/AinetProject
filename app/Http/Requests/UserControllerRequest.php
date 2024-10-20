<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserControllerRequest extends FormRequest
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
            'nif' => 'nullable|string',
            'address' => 'nullable|string',
            'photo_url' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tipo' => 'required|string|in:C,E,A',
            'password' =>'sometimes|string',
        ];
    }
}
