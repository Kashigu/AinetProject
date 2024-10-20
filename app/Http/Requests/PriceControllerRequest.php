<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceControllerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'catalogPrice' => 'required|string',
            'proprioPrice' => 'required|string',
            'discountCatalog' => 'required|string',
            'discountProprio' => 'required|string',
            'quanti' => 'required|string',
        ];
    }
}
