<?php

namespace App\Http\Controllers\Api\User\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CoreModule\UserProfessionRequest;
use App\Http\Requests\Api\User\Profession\DeleteProfessionRequest;
use App\Http\Requests\Api\User\Profession\EditProfessionRequest;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfessionController extends Controller
{
    public function userProfession(UserProfessionRequest $request)
    {
        
        foreach($request->company as $key => $company){
            $data = [
                'user_id' => auth()->id(),
                'company' => $company,
                'designation' => $request->designation[$key],
                'start_date' => $request->start_date[$key],
                'end_date' => $request->end_date[$key],
                'reason_of_leaving' => $request->reason_of_leaving[$key],
                
            ];
            Profession::create($data);
        }

        return commonSuccessMessage("Profession Added Successfully");

    }

    public function editProfession(EditProfessionRequest $request)
    {
        $profession = Profession::find($request->profession_id);
        
        if ( !$profession )
            return commonErrorMessage("Not Found", 404);

        if ( $profession->user_id != auth()->id() )
            return commonErrorMessage("Can not Update", 400);

        $profession->update($request->validated() + ['reason_of_leaving' => $request->reason_of_leaving]);

        return apiSuccessMessage("Updated Successfully", $profession);
    }
    public function getProfession() 
    {
        $user_profession = DB::table('professions')
                                ->select(
                                    'id',
                                    'company',
                                    'designation',
                                    'start_date',
                                    'end_date',
                                    'reason_of_leaving',
                                )
                                ->where('user_id', auth()->id())
                                ->get();
        return apiSuccessMessage("Profession", $user_profession);
    }

    public function deleteProfession(DeleteProfessionRequest $request)
    {
        $delete_profession = Profession::find($request->id);

        if ( !$delete_profession )
        {
            return commonErrorMessage("Not Found", 404);
        }

        $delete_profession->delete();
        return commonSuccessMessage("Success");
    }
}
