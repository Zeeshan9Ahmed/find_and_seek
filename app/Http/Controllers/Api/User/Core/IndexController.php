<?php

namespace App\Http\Controllers\Api\User\Core;

use App\Events\SendNotificationToAdminEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CoreModule\AllowPermissionRequest;
use App\Http\Requests\Api\User\CoreModule\ContentRequest;
use App\Http\Requests\Api\User\CoreModule\DeleteImageRequest;
use App\Http\Requests\Api\User\CoreModule\UpdateLocationRequest;
use App\Mail\SendSoSMailToAdmin;
use App\Models\Content;
use App\Models\Photo;
use Illuminate\Support\Facades\File; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class IndexController extends Controller
{
    // public function deleteLicenseImage(DeleteImageRequest $request)
    // {
        
        
    //     $license_image = Photo::find($request->image_id);
        
        
    //     if ( !$license_image )
    //     {
    //         return commonErrorMessage("No Image Found", 404);
    //     }
        
    //     if( $license_image->user_id != auth()->id() )
    //     {
    //         return commonErrorMessage("Can not delete Image ", 400);
    //     }
    //     $imageName =  last(explode('public/',$license_image->license_image));
    //     if(File::exists(public_path($imageName)))
    //     {
    //         File::delete(public_path($imageName));
    //     }
    //     if ( $license_image->delete() )
    //     {
    //         return commonSuccessMessage("Image Deleted Succesfully");
    //     }

    //     return commonErrorMessage("Something Went Wrong, Please try again", 400);

    // }

    public function LevelOfEducations() 
    {
        $level_of_education = DB::table('level_of_education')
                                ->select(
                                    'id',
                                    'education_name'
                                )
                                ->get();
        return apiSuccessMessage("Level Of Education", $level_of_education);
    }
    
    public function IdealRoles()
    {
        $ideal_roles = DB::table('ideal_roles')
                        ->select(
                            'id',
                            'role_name'
                        )
                        ->get();
        return apiSuccessMessage("Ideal Roles", $ideal_roles);
    }

    public function content(ContentRequest $request)
    {
        $content = Content::where('slug', $request->slug)->first();
        if ( !$content )
            return commonErrorMessage("No Content Found", 404);
        

        return apiSuccessMessage("Content", $content);
    }

    
}
