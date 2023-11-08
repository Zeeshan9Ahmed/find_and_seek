<?php

namespace App\Http\Requests\Api\User\CoreModule;

use Illuminate\Foundation\Http\FormRequest;

class UserEducationRequest extends FormRequest
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
            'level_of_education.*' => 'required',
            'degree.*' => 'required',
            'major.*' => 'required',
            'passing_year.*' => 'required',
            'percentage.*' => 'required',
            'school_name.*' => 'required',
        ];
    }
}
