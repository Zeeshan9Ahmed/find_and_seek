<?php

namespace App\Http\Controllers\Api\User\OTP;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\OTP\OtpVerifyRequest;
use App\Http\Resources\LoggedInUser;
use App\Models\User;
use App\Services\OTP\AccountVerification;
use App\Services\OTP\ValidateOTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function otpVerify(OtpVerifyRequest $request) 
    {
        $data = $request->only('email', 'reference_code', 'type');
        $check_otp = app(ValidateOTP::class)->execute($data);
        
        if($request->type === "ACCOUNT_VERIFICATION")
        {
            $user = app(AccountVerification::class)->execute(['email'=>$check_otp->email]);
            $token = $user->createToken('authToken')->plainTextToken;
            
            return apiSuccessMessage("Account Verified Successfully", new LoggedInUser(User::logged_in_user($user->id)), $token);
        }elseif($request->type==="PASSWORD_RESET"){
            
            return commonSuccessMessage("Success", 200);
        }
    }
}
