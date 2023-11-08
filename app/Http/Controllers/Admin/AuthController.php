<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Admin;
use DB;
use Carbon\Carbon;
use App\Mail\SendEmail;

class AuthController extends Controller
{
    public function login()
    {
            return view('admin.login');
    }


    public function login_process(Request $request)
    {
        $controls=$request->all();
        $rules=array(
            'email'=>"required|exists:admins,email",
            "password"=>"required");
        $validator=Validator::make($controls,$rules);
        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $admin = Admin::where('email', $request->email)->first();

        if (Hash::check($request->password, $admin->password)) {
            Auth::guard('isAdmin')->login($admin);

            return redirect()->route('dashboard');
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Incorrect email address or password']);
    }

    public function logout()
    {
        Auth::guard('isAdmin')->logout();
        return redirect('/admin-login');
    }

    public function dashboard()
    {
        $users = User::where('role','user')->count();
        $company = User::where('role','!=','user')->count();
        return view('admin.dashboard',['users' => $users, 'company' => $company]);
    }
}