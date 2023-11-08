<?php

namespace App\Http\Controllers\Api\User\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CoreModule\UserEducationRequest;
use App\Http\Requests\Api\User\Education\DeleteEducationRequest;
use App\Http\Requests\Api\User\Education\EditEducationRequest;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EducationController extends Controller
{
    public function userEducation(UserEducationRequest $request)
    {
        foreach($request->level_of_education as $key => $level){
            $data = [
                'user_id' => auth()->id(),
                'level_of_education' => $request->level_of_education[$key] ,
                'degree' => $request->degree[$key],
                'major' => $request->major[$key],
                'passing_year' => $request->passing_year[$key],
                'percentage' => $request->percentage[$key],
                'school_name' => $request->school_name[$key],
                
            ];
            
            Education::create($data);
        }

        return commonSuccessMessage("Education Added Successfully");
        return $request->all();
    }


    public function editEducation(EditEducationRequest $request)
    {
        $education = Education::find($request->education_id);

        if ( !$education )
            return commonErrorMessage("Not Found", 400);

        if ( $education->user_id != auth()->id() )
            return commonErrorMessage("Can not Update", 400);

            $education->update($request->validated());
                return apiSuccessMessage("Updated Successfully", $education);
    }

    public function getEducation() 
    {
        $user_education = DB::table('education')
                                ->select(
                                    'id',
                                    'level_of_education',
                                    'degree',
                                    'major',
                                    'passing_year',
                                    'percentage',
                                    'school_name',
                                )
                                ->where('user_id', auth()->id())
                                ->get();
        return apiSuccessMessage("Education", $user_education);
    }

    public function deleteEducation(DeleteEducationRequest $request)
    {
        $delete_education = Education::find($request->id);

        if ( !$delete_education )
        {
            return commonErrorMessage("Not Found", 404);
        }

        $delete_education->delete();
        return commonSuccessMessage("Success");
    }
}
