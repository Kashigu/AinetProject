<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TshirtImageRequest extends FormRequest
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
            'idUser'=>'nullable|integer',
            'idCategory'=>'nullable|integer',
            'name' =>'required|string',
            'description' =>'required|string',
        ];

        if ($this->isMethod('POST')) {
            $rules['image_url'] = 'required|image|max:4096';
        } elseif ($this->isMethod('PUT')) {

            $rules['image_url'] = 'sometimes|image|max:4096';

        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' =>  'O nome é obrigatório',
            'description' => 'A descricao é obrigatória',
            'image_url.image' => 'O ficheiro com a foto não é uma imagem',
            'image_url.size' => 'O tamanho do ficheiro com a foto tem que ser inferior a 4 Mb'
        ];
    }
}
