<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
            return view('auth.login');
    }

    public function login(LoginRequest $request){
        $credentials = request(['email','password']);
        $credentials['role'] = 'admin';
        if(Auth::attempt($credentials))
        {
            $redirect = url("admin/dashboard");
            $user = Auth::user();
            $user->device_token = $request->device_token;
            $user->save();
            return webcommonSuccessMessage ('Admin Login successfully!', false, $redirect);
        }   
                return webcommonErrorMessage('Sorry Invalid Email or Password');
          
        

    }
    public function logout(){
        
        if(Auth::check()){
            Auth::logout();
            return redirect()->route('loginform');
        }
        return redirect()->route('loginform');

    }
}
