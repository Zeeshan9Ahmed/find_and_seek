<?php

namespace App\Http\Controllers\Api\User\Profile;

use App\Events\ProfileViewEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\User\Auth\CompleteProfileRequest;
use App\Http\Requests\Api\User\CoreModule\SearchUserRequest;
use App\Http\Requests\Api\User\Profile\GetUserProfileRequest;
use App\Http\Requests\Api\User\Profile\UpdateCompanyProfileRequest;
use App\Http\Requests\Api\User\Profile\UpdateIndividualProfileRequest;
use App\Http\Requests\Api\User\Profile\UpdateProfileRequest;
use App\Http\Requests\Api\User\Profile\UpdateResumeRequest;
use App\Http\Resources\LoggedInUser;
use App\Http\Resources\UserResumeResource;
use App\Models\Company;
use App\Models\Notification;
use App\Models\Photo;
use App\Models\Pitch;
use App\Models\ProfileView;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Str;


class ProfileController extends Controller
{

    public function profile(GetUserProfileRequest $request)
    {
        $user = User::find($request->user_id);

        if (!$user)
            return commonErrorMessage("Not Found", 404);

        if ( auth()->id() != $user->id) {
            // return 'false';
            $this->analytics($user->id);
        }
        return apiSuccessMessage("Profile Data", new LoggedInUser(User::logged_in_user($user->id)));

    }

    public function searchUsers(SearchUserRequest $request)
    {
        $users = User::with('pitches','rep_pitches')
                        ->with(['professions'])
                        // ->whereHas('professions', function ($query) use ($request){
                        //     $query->where('designation', $request->key_word);
                        // })
                        ->leftjoin('professions',  'users.id', 'professions.user_id')
                        ->leftjoin('companies',  'users.id', 'companies.user_id')
                        ->select(
                            'users.id',
                            'users.full_name',
                            'users.email',
                            'users.avatar',
                            'users.contact',
                            'users.current_role',
                            'users.address',
                            'users.city',
                            'users.state',
                            'users.role',
                            'users.is_social',
                            'profile_completed',
                            'device_type',
                            'device_token',
                            'email_verified_at',
                            'role',
                            'user_resume',
                            'resume_title',
                            'resume_description',
                            'zip_code',
                            'ideal_roles',
                            'representative_avatar',
                            'representative_name',
                            'representative_email',
                            'representative_contact',
                            'representative_address',
                            'representative_city',
                            'representative_state',
                            'representative_zip_code',
                            'company_employess'
                        )
                        ->whereRaw(' (users.full_name LIKE "%'.$request->key_word.'%" OR professions.designation LIKE "%'.$request->key_word.'%")  AND users.role = "user" ')
                        ->groupBy('users.id','users.full_name')
                        // ->toSql();
                        ->get();
        // return $users;         
        return apiSuccessMessage("Users Search", LoggedInUser::collection($users));
    }

    protected function analytics($user_id)
    {
        return $this->checkIfUserHasAlreadyViewedProfile([ 'seen_by' => auth()->id() , 'user_id' => $user_id]);
    }

    protected function checkIfUserHasAlreadyViewedProfile(array $data)
    {
        if(! ProfileView::where($data)->exists() ) 
            return $this->viewProfile($data);
        

        return Notification::where(['from_user_id' => auth()->id(), 'to_user_id' => $data['user_id']])->first()->update(['created_at' => Carbon::now()]);

    }

    protected function viewProfile(array $data) 
    {
        ProfileView::create($data);
        return $this->sendNotificationofProfileView($data['user_id']);
    }

    protected function sendNotificationofProfileView( $user_id) 
    {
        $data = [
            'to_user_id'        =>  $user_id,
            'from_user_id'      =>  auth()->id(),
            'notification_type' =>  'PROFILE_VIEW',
            'title'             =>  auth()->user()->full_name ." has viewed your profile " ,
            'redirection_id'    =>   auth()->id(),
            'description'       => 'PROFILE DESCRIPTION',
            'full_name'         => auth()->user()->full_name,
        ];

        $token = DB::table('users')->select('device_token')->where('id', $user_id)->value('device_token');
         event( new ProfileViewEvent($data, $token));

    }
    public function notifications() 
    {
        $notifications = DB::table('notifications')
                            ->join('users', 'users.id', 'notifications.from_user_id')
                            ->select(
                                'notifications.id',
                                'title',
                                'redirection_id',
                                'notification_type',
                                'users.id as user_id',
                                'full_name',
                                'avatar',
                                'notifications.created_at'
                            )
                            ->where('to_user_id', auth()->id())
                            ->when(auth()->user()->role == 'user', function($query){

                                $query->orWhere('to_user_id', 0)->where('notifications.created_at', '>', auth()->user()->created_at);
                            })
                            ->orderByDesc('notifications.id')->get();
                            
        return apiSuccessMessage("Notifications", $notifications);
    }

    public function deleteAccount()
    {
        if ( auth()->user()->delete() )
        {
            return commonSuccessMessage("Account Deleted Successfully");
        }
        
    }


    public function updateResume(UpdateResumeRequest $request) 
    {
        $user = Auth::user();
        $file = '';
        if ( $user->user_resume != '')
        {
            removeFile( $user->user_resume );   
        }
        if($request->hasFile('resume'))
        {
            $fileName = time().'.'.$request->resume->getClientOriginalExtension();
            $request->resume->move(public_path('/uploadedresume'), $fileName);
            $file = asset('public/uploadedresume')."/".$fileName;
        }

        

        $user->user_resume = $file;
        $user->resume_title = $request->resume_title;
        $user->resume_description = $request->resume_description;

        $user->save();
        return commonSuccessMessage("Success");
    }

    public function getResume()
    {
        if ( ! auth()->user()->user_resume )
            return commonErrorMessage("No Resume", 404);
               
        return apiSuccessMessage("User Resume", new UserResumeResource(auth()->user()));
    }

    public function completeProfile(CompleteProfileRequest $request)
    {
        $role = $request->role;
        
        $user = Auth::user();
        if (!$user->role){
            $user->role = $role;
            
            if ($role == 'company')
            {
                Company::create([
                    'user_id' => $user->id
                ]);
            }
            $user->save();
        }
        
        if($request->hasFile('avatar'))
        {
            $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('/uploadedimages'), $imageName);
            $avatar = asset('public/uploadedimages')."/".$imageName;
            $user->avatar = $avatar;
        }


        
        
        if($user->profile_completed == 0 && $request->hasFile('pitch')){
            $uuid = Str::uuid();
            
            // $file_thumb_ = makeThumbnail($request->file('pitch'));
            $file_thumb_ = "";
            $imageName = $uuid. time().'.'.$request->pitch->getClientOriginalExtension();
            $request->pitch->move(public_path('/uploadedpitches'), $imageName);
            $pitch_url = asset('public/uploadedpitches')."/".$imageName;
            
                $data = new Pitch([
                    'pitch_url' => $pitch_url,
                    'thumbnail' => $file_thumb_,
                ]);
                auth()->user()->model()->save($data);
        }

        if($user->profile_completed == 0 && $request->hasFile('rep_pitch')){
            $uuid = Str::uuid();
            // $file_thumb_ = makeThumbnail($request->file('rep_pitch'));
            $file_thumb_ = "";
            $imageName = $uuid. time().'.'.$request->rep_pitch->getClientOriginalExtension();
            $request->rep_pitch->move(public_path('/uploadedpitches'), $imageName);
            $pitch_url = asset('public/uploadedpitches')."/".$imageName;
            
                $data = new Pitch([
                    'pitch_url' => $pitch_url,
                    'type' => 'rep_pitch',
                    'thumbnail' => $file_thumb_,
                ]);
                auth()->user()->model()->save($data);
        }

        $user->full_name = $request->full_name;
        $user->contact = $request->contact;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip_code = $request->zip_code;
        $user->job_title = $request->job_title;
        
        if ($user->role == 'user' || $user->role == 'individual')
        {
            $user->profile_completed = 1;
        }
        if ( $user->role == 'user' )
        {
            $user->ideal_roles = $request->ideal_roles;     
            $user->current_role = $request->current_role;
        }        
        
        $user->is_active = "1";
        $user->is_social = "0";
        
        if ( $user->role == 'company')
        {
            $company = Company::where('user_id' , $user->id )->first();
            // return $company;
            
            if ( !$company )
            {
                return commonErrorMessage("Can't Update", 400);
            }

            if($request->hasFile('rep_avatar'))
            {
                $uuid = Str::uuid();
                $imageName = $uuid . time() . '.' . $request->rep_avatar->getClientOriginalExtension();
                $request->rep_avatar->move(public_path('/uploadedimages'), $imageName);
                $avatar = asset('public/uploadedimages')."/".$imageName;
                $company->representative_avatar = $avatar;
                
            }
            $company->company_name = $request->full_name;

            $company->representative_name = $request->rep_name;
            $company->representative_email = $request->rep_email;
            
            $company->representative_contact = $request->rep_contact;
            $company->representative_address = $request->rep_address;
            $company->representative_city = $request->rep_city;
            $company->representative_state = $request->rep_state;
            $company->representative_zip_code = $request->rep_zipCode;
            $company->company_employess = $request->company_employess;
            
            $company->save();
            $user->profile_completed = 1;
        }
        if ( $user->save() )
        {
            return apiSuccessMessage("Profile Updated Successfully", new LoggedInUser(User::logged_in_user($user->id)));

            return commonSuccessMessage("Profile Updated Successfully");
        }

        return commonErrorMessage("Something went wrong" , 400);
        
    }

    

    

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        if (!Hash::check($request->old_password , $user->password))
        {
            return commonErrorMessage("InCorrect Old password , please try again",400);
        }

        if (Hash::check($request->new_password , $user->password))
        {
            return commonErrorMessage("New Password can not be match to Old Password",400);
        } 
        
        $user->password = bcrypt($request->new_password);
        $user->save();
        if( $user )
        {
            return commonSuccessMessage("Password Updated Successfully");
        }
            return commonErrorMessage("Something went wrong while updating old password", 400);
         
    
    }
}
