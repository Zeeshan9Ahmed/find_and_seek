<?php

namespace App\Http\Requests\Api\User\Job;

use Illuminate\Foundation\Http\FormRequest;

class GetJobRequest extends FormRequest
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
            'job_id' => 'required|exists:jobs,id'
        ];
    }
}
