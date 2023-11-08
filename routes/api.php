<?php

use App\Http\Controllers\Api\User\Auth\LoginController;
use App\Http\Controllers\Api\User\Auth\PasswordController;
use App\Http\Controllers\Api\User\Auth\SignUpController;
use App\Http\Controllers\Api\User\Core\EducationController;
use App\Http\Controllers\Api\User\Core\IndexController;
use App\Http\Controllers\Api\User\Core\ProfessionController;
use App\Http\Controllers\Api\User\Filter\FilterController;
use App\Http\Controllers\Api\User\Home\HomeController;
use App\Http\Controllers\Api\User\Job\JobController;
use App\Http\Controllers\Api\User\Message\MessageController;
use App\Http\Controllers\Api\User\OTP\VerificationController;
use App\Http\Controllers\Api\User\Pitch\PitchController;
use App\Http\Controllers\Api\User\Profile\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/login', function () {
    return response()->json(["status"=>0,"message"=>"Sorry User is Unauthorize"], 401);
})->name('login');

Route::post('signup', [SignUpController::class, 'signUp']);

Route::post('signup/resend-otp', [SignUpController::class, 'resendSignUpOtp']);

Route::post('otp-verify', [VerificationController::class, 'otpVerify']);

Route::post('login', [LoginController::class, 'login']);

Route::post('social', [LoginController::class, 'socialAuth']);

Route::post('forgot-password', [PasswordController::class, 'forgotPassword']);
Route::post('reset/forgot-password', [PasswordController::class, 'resetForgotPassword']);

Route::get('content', [IndexController::class, 'content']);
Route::get('level-of-education', [IndexController::class, 'LevelOfEducations']);
Route::get('ideal-roles', [IndexController::class, 'IdealRoles']);


Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('change-password', [ProfileController::class , 'changePassword']);
    Route::post('update-profile', [ProfileController::class , 'completeProfile']);
    Route::get('notifications', [ProfileController::class , 'notifications']);

    
    
    Route::post('user-education', [EducationController::class , 'userEducation']);
    Route::post('edit-education', [EducationController::class , 'editEducation']);
    Route::get('get-education', [EducationController::class , 'getEducation']);
    Route::delete('delete-education', [EducationController::class , 'deleteEducation']);
    
    Route::post('user-profession', [ProfessionController::class , 'userProfession']);
    Route::post('edit-profession', [ProfessionController::class , 'editProfession']);
    Route::get('get-profession', [ProfessionController::class , 'getProfession']);
    Route::delete('delete-profession', [ProfessionController::class , 'deleteProfession']);


    Route::post('create-job', [JobController::class , 'createJob']);
    Route::get('all-jobs', [JobController::class , 'allJobs']);
    Route::get('search-job-company', [JobController::class , 'SearchJobOrCompany']);
    
    Route::post('edit-job', [JobController::class , 'editJob']);
    Route::get('my-jobs', [JobController::class , 'myJobs']);
    Route::get('jobs/{id}', [JobController::class , 'getJob']);
    Route::delete('delete-job', [JobController::class , 'deleteJob']);
    
    
    
    Route::get('get-pitches', [PitchController::class , 'getPitches']);
    Route::get('exceptional-pitches', [PitchController::class , 'exceptionalPitches']);
    Route::get('get-my-pitches', [PitchController::class , 'getMyPitches']);
    
    Route::get('get-received-pitches', [PitchController::class , 'getReceivedPitches']);

    Route::post('upload-pitch', [PitchController::class , 'uploadPitch']);
    Route::post('send-pitch', [PitchController::class , 'sendPitch']);
    Route::get('search-pitch', [PitchController::class , 'searchPitch']);
    Route::delete('delete-pitch', [PitchController::class , 'deletePitch']);



    Route::get('home-data', [HomeController::class , 'homeData']);
    Route::get('analytics', [HomeController::class , 'analytics']);
    Route::get('view/analytics/data', [HomeController::class , 'analyticsData']);

    Route::post('filter', [FilterController::class , 'save']);
    Route::get('filter', [FilterController::class , 'get']);
    Route::delete('filter', [FilterController::class , 'delete']);


    Route::get('chat-list', [MessageController::class , 'chatList']);
    Route::post('send-attachment', [MessageController::class , 'sendAttachment']);
    Route::post('chat-status', [MessageController::class , 'chatStatus']);


    Route::get('profile', [ProfileController::class , 'profile']);
    Route::get('search-users', [ProfileController::class , 'searchUsers']);
    Route::post('update-resume', [ProfileController::class , 'updateResume']);
    Route::get('get-resume', [ProfileController::class , 'getResume']);
    Route::delete('delete-account', [ProfileController::class , 'deleteAccount']);

    Route::post('logout', [LoginController::class , 'logout']);

    
});