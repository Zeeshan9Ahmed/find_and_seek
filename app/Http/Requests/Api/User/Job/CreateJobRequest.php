<?php

namespace App\Http\Requests\Api\User\Job;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'job_type' => 'required',
            'location' => 'required',
            'from' => 'nullable',
            'to' => 'nullable',
            'salary_type' => 'nullable',
            'other' => 'nullable',
        ];
    }
}
