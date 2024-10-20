<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorControllerRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string',
            'code' => 'required|string',
        ];

        if ($this->isMethod('POST')) {
            $rules['image_url'] = 'required|image|mimes:jpg,jpeg|max:4096';
        } elseif ($this->isMethod('PUT')) {

                $rules['image_url'] = 'sometimes|image|mimes:jpg,jpeg|max:4096';

        }

        return $rules;
    }


    public function messages(): array
    {
        return [
            'name.required' =>  'O nome é obrigatório',
            'code' =>  'O codigo é obrigatório',
            'image_url' =>  'A imagem é obrigatória e tem que ser .jpg',
        ];
    }
}
