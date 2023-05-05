<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BreedParkRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'breed_id' => [
                'required',
                'string',
            ]
        ];
    }
}
