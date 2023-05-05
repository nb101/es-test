<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserAssociateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validationRules  = [
            'type' => [
                'required',
                'string',
                Rule::in(['park', 'breed']),

            ]
        ];

        if($this->type == 'park') {
            $validationRules['park_id'] = ['required','numeric'];
        }
        if($this->type == 'breed') {
            $validationRules['breed_id'] = ['required','string'];
        }

        return $validationRules;
    }
}
