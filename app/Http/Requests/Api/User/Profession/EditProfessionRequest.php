<?php

namespace App\Http\Requests\Api\User\Profession;

use Illuminate\Foundation\Http\FormRequest;

class EditProfessionRequest extends FormRequest
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
            'profession_id' => "required|numeric",
            'company' => "required",
            'designation' => "required",
            'start_date' => "required",
            'end_date' => "required",
            // 'reason_of_leaving' => "nullable|required",
        ];
    }
}
