<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'INN' => ['required','string', 'max:12'],
            'KPP' => ['required', 'string', 'max:9'],
            'name' => ['required','string'],
            'field_of_activity' => ['required','string'],
            'description' => ['string'],
            'contact' => ['required','string'],
        ];
    }
}
