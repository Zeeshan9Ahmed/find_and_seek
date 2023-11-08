<?php

namespace App\Http\Controllers\Api\User\Filter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Filter\DeleteFilterRequest;
use App\Models\Filter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function save(Request $request)
    {
        // return $request->all();
         Filter::updateOrCreate(
            ['user_id' => auth()->id()], 
            [
                'job_title' => $request->job_title,
                'start_salary' => (int)$request->start_salary??0,
                'end_salary' => (int) $request->end_salary??0,
                'benefits' => $request->benefits,
            ]);
        
        return commonSuccessMessage("Success");
        
    }

    public function get(Request $request)
    {
        $filter = Filter::where('user_id', auth()->id())->first();
        if(!$filter)
        return commonErrorMessage("Not Found",400);
        $filter->benefits = $filter->benefits?explode(',',$filter->benefits):[];
        return apiSuccessMessage("Filter", $filter);
    }

    public function delete(DeleteFilterRequest $request)
    {
        $filter = Filter::where('id', $request->filter_id)->delete();
        
        return commonSuccessMessage("Success");
    }
    

    
}
