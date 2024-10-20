<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user() != null;
    }
    public function rules(): array
    {
        return [
            'currentpassword' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    return $fail('A password atual é incorreta.');
                }
            }],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
