<?php

namespace App\Http\Requests\Api\User\CoreModule;

use Illuminate\Foundation\Http\FormRequest;

class UserProfessionRequest extends FormRequest
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
            'company' => "required|array",
            'company.*' => "required|string",
            'designation' => "required|array",
            'designation.*' => 'required|string',
            'start_date' => "required|array",
            'start_date.*' => 'required|string',
            'end_date' => "required|array",
            'end_date.*' => 'required|string',
            // 'reason_of_leaving' => "required|array",
            // 'reason_of_leaving.*' => 'required|string',
        ];
    }
}
