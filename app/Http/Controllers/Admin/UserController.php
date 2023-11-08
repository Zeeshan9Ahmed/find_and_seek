<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Content;
use App\Models\Company;

use DB;
use Carbon\Carbon;
use App\Mail\SendEmail;


Class UserController extends Controller
{
	public function users()
	{
		$users = User::where('role','user')->orderBy('id','DESC')->get();
		return view('admin.users.index',['users' => $users]);
	}

	public function create_user()
	{
		return view('admin.users.create_user');
	}

	public function store_user(Request $request)
	{
		$controls=$request->all();
		$rules=array(
		     "full_name"=>"required",
		     "email"=>"required",
		     "password"=>"required",
		     "avatar"=>"required",
		     "contact"=>"required",
		     "address"=>"nullable",
		     "city"=>"nullable",
		     "state"=>"nullable",
		     "zipcode"=>"nullable",
		     "resume_title"=>"nullable",
		     "resume_description"=>"nullable",
		     "resume"=>"nullable",

		);
		$validator=Validator::make($controls,$rules);
		if ($validator->fails()) {
		       return redirect()->back()->withErrors($validator)->withInput();
		}
	
		$user = new User;
		$user->full_name = $request->full_name;
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->role = 'user';
		$user->contact = $request->contact;
		$user->address = $request->address;
		$user->city = $request->city;
		$user->state = $request->state;
		$user->zip_code = $request->zipcode;
		$user->resume_title = $request->resume_title;
		$user->resume_description = $request->resume_description;

		if($request->hasFile('resume')){
               $imageName = time().'.'.$request->resume->getClientOriginalExtension();
               $request->resume->move(public_path('/uploadedresume/'), $imageName);
               $user->user_resume = asset('public/uploadedresume')."/".$imageName;
        }
	

        if($request->hasFile('avatar')){
               $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
               $request->avatar->move(public_path('/uploadedimages/'), $imageName);
               $user->avatar=asset('public/uploadedimages')."/".$imageName;
        }

        $user->save();

        return redirect()->route('users')->withSuccess('User Added Successfully...!');
    }

    public function edit_user($id)
    {
    	$user = User::find($id);
    	return view('admin.users.edit_user',['user' => $user]);
    }


    public function update_user(Request $request)
	{
		$controls=$request->all();
		$rules=array(
			 "user_id" => "required",
		     "full_name"=>"required",
		     "email"=>"required",
		     // "password"=>"required",
		     // "avatar"=>"required",
		     "contact"=>"required",
		     "address"=>"nullable",
		     "city"=>"nullable",
		     "state"=>"nullable",
		     "zipcode"=>"nullable",
		     "resume_title"=>"nullable",
		     "resume_description"=>"nullable",
		     "resume"=>"nullable",

		);
		$validator=Validator::make($controls,$rules);
		if ($validator->fails()) {
		       return redirect()->back()->withErrors($validator)->withInput();
		}
	
		$user = User::find($request->user_id);
		$user->full_name = $request->full_name;
		// $user->email = $request->email;
		if($request->password)
		{
			$user->password = Hash::make($request->password);
		}
		
		// $user->role = 'user';
		$user->contact = $request->contact;
		$user->address = $request->address;
		$user->city = $request->city;
		$user->state = $request->state;
		$user->zip_code = $request->zipcode;
		$user->resume_title = $request->resume_title;
		$user->resume_description = $request->resume_description;

		if($request->hasFile('resume')){

		$ex = explode("findnseek/",$user->user_resume);
        	unlink($ex[1]);

               $imageName = time().'.'.$request->resume->getClientOriginalExtension();
               $request->resume->move(public_path('/uploadedresume/'), $imageName);
               $user->user_resume = asset('public/uploadedresume')."/".$imageName;
        }
	

        if($request->hasFile('avatar')){

        	$ex = explode("findnseek/",$user->avatar);
        	unlink($ex[1]);

               $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
               $request->avatar->move(public_path('/uploadedimages/'), $imageName);
               $user->avatar=asset('public/uploadedimages')."/".$imageName;
        }

        $user->save();

        return redirect()->route('users')->withSuccess('User Updated Successfully...!');
    }

    public function destroy_user(Request $request)
	{
		User::destroy($request->id);
	}

	public function company()
	{
		$users = User::with('company')->where('role','!=','user')->orderBy('id','DESC')->get();
		return view('admin.users.company',['users' => $users]);
	}

	public function create_company()
	{
		return view('admin.users.create_company');
	}

	public function store_company(Request $request)
	{
		$controls=$request->all();
		$rules=array(
		     "full_name"=>"required",
		     "email"=>"required",
		     "password"=>"required",
		     "avatar"=>"required",
		     "contact"=>"required",
		     "address"=>"nullable",
		     "city"=>"nullable",
		     "state"=>"nullable",
		     "zipcode"=>"nullable",
		     "company_name"=>"required",
		     "rep_name"=>"required",
		     "rep_email"=>"required",
		     "rep_contact" => "required",
		     "rep_avatar" => "required",
		     "rep_address" => "nullable",
		     "rep_city" => "nullable",
		     "rep_state" => "nullable",
		     "rep_zipcode" => "nullable"
		);
		$validator=Validator::make($controls,$rules);
		if ($validator->fails()) {
		       return redirect()->back()->withErrors($validator)->withInput();
		}
	
		$user = new User;
		$user->full_name = $request->company_name;
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->role = 'company';
		$user->contact = $request->contact;
		$user->address = $request->address;
		$user->city = $request->city;
		$user->state = $request->state;
		$user->zip_code = $request->zipcode;	
	
	        if($request->hasFile('avatar')){
	               $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
	               $request->avatar->move(public_path('/uploadedimages/'), $imageName);
	               $user->avatar=asset('public/uploadedimages')."/".$imageName;
	        }

	        $user->save();

	        $company = new Company;
	        $company->user_id = $user->id;
	        $company->company_name = $request->full_name;
	        $company->representative_name = $request->rep_name;
	        $company->representative_email = $request->rep_email;
	        $company->representative_contact = $request->rep_contact;
	        $company->representative_address = $request->rep_address;
	        $company->representative_city = $request->rep_city;
	        $company->representative_state = $request->rep_state;
	        $company->representative_zip_code = $request->rep_zipcode;

	        if($request->hasFile('rep_avatar')){
	               $imageName = time().'.'.$request->rep_avatar->getClientOriginalExtension();
	               $request->rep_avatar->move(public_path('/uploadedimages/'), $imageName);
	               $company->representative_avatar=asset('public/uploadedimages')."/".$imageName;
	        }

	        $company->save();

        return redirect()->route('recruiters')->withSuccess('Recruiters Added Successfully...!');
    }

    public function edit_company($id)
    {
    	$users = User::with('company')->where('id',$id)->first();
	return view('admin.users.edit_company',['user' => $users]);
    }

    public function update_company(Request $request)
	{
		$controls=$request->all();
		$rules=array(
			"user_id" => "required",
		     "full_name"=>"required",
		     "email"=>"required",
		     // "password"=>"required",
		     // "avatar"=>"required",
		     "contact"=>"required",
		     "address"=>"nullable",
		     "city"=>"nullable",
		     "state"=>"nullable",
		     "zipcode"=>"nullable",
		     "company_name"=>"required",
		     "rep_name"=>"required",
		     "rep_email"=>"required",
		     "rep_contact" => "required",
		     // "rep_avatar" => "required",
		     "rep_address" => "nullable",
		     "rep_city" => "nullable",
		     "rep_state" => "nullable",
		     "rep_zipcode" => "nullable"
		);
		$validator=Validator::make($controls,$rules);
		if ($validator->fails()) {
		       return redirect()->back()->withErrors($validator)->withInput();
		}
	
		$user = User::find($request->user_id);
		$user->full_name = $request->company_name;
		// $user->email = $request->email;
		if($request->password)
		{
		    $user->password = Hash::make($request->password);
		}
		$user->contact = $request->contact;
		$user->address = $request->address;
		$user->city = $request->city;
		$user->state = $request->state;
		$user->zip_code = $request->zipcode;	
	
	        if($request->hasFile('avatar')){

	        	$ex = explode("findnseek/",$user->avatar);
        		unlink($ex[1]);

	               $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
	               $request->avatar->move(public_path('/uploadedimages/'), $imageName);
	               $user->avatar=asset('public/uploadedimages')."/".$imageName;
	        }

	        $user->save();

	        $company = Company::where('user_id',$request->user_id)->first();
	        // $company->user_id = $user->id;
	        $company->company_name = $request->full_name;
	        $company->representative_name = $request->rep_name;
	        $company->representative_email = $request->rep_email;
	        $company->representative_contact = $request->rep_contact;
	        $company->representative_address = $request->rep_address;
	        $company->representative_city = $request->rep_city;
	        $company->representative_state = $request->rep_state;
	        $company->representative_zip_code = $request->rep_zipcode;

	        if($request->hasFile('rep_avatar')){

	        	$ex = explode("findnseek/",$company->representative_avatar);
        		unlink($ex[1]);

	               $imageName = time().'.'.$request->rep_avatar->getClientOriginalExtension();
	               $request->rep_avatar->move(public_path('/uploadedimages/'), $imageName);
	               $company->representative_avatar=asset('public/uploadedimages')."/".$imageName;
	        }

	        $company->save();

        return redirect()->route('recruiters')->withSuccess('Recruiters Updated Successfully...!');
    }

    public function destroy_company(Request $request)
	{
		// Pitch::destroy($request->id);
		$user = User::where('id',$request->id)->delete();
		$company = Company::where('user_id',$request->id)->delete();
	}
	
	public function show_deleted_users()
	{
// 		$users = User::where('role','user')->orderBy('id','DESC')->where('deleted_at','!=',null)->get();
		$users = User::where('role','user')->onlyTrashed()->get();
// 		dd($users);
		return view('admin.users.deleted_user',['users' => $users]);
	}
	
	public function restore_user($id)
	{
	   // $user = User::find($id);
	    $user = User::where('id',$id)->withTrashed()->first();
	   // dd($user);
	    if ($user->trashed()) {
            $user->restore();
            return redirect()->back()->withSuccess('User Restored Successfully...!');
        }
	   // if($user)
	   // {
	   //     return redirect()->back()->withSuccess('User Restored Successfully...!');
	   // }
	}
	
	
	public function show_deleted_recruiters()
	{
// 		$users = User::where('role','user')->orderBy('id','DESC')->where('deleted_at','!=',null)->get();
		$users = User::where('role','!=','user')->onlyTrashed()->get();
// 		dd($users);
		return view('admin.users.deleted_company',['users' => $users]);
	}
	
}

