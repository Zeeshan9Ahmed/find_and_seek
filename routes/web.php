<?php

// use App\Http\Controllers\Admin\Admin\AdminController;
// use App\Http\Controllers\Admin\Notification\NotificationController;
// use App\Http\Controllers\Admin\Page\PageController;
// use App\Http\Controllers\Admin\User\UserController;
// use App\Http\Controllers\Web\Admin\ForgotPasswordController;
// use App\Http\Controllers\Web\Admin\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PitchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/login', function () {
//     return response()->json(["status"=>0,"message"=>"Sorry User is Unauthorize"], 401);
// })->name('login');


//Admin Panel
Route::get('/admin-login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class,'login_process'])->name('login-process');

// Route::get('/forgot-password',[ForgotPasswordController::class,'forgotPasswordForm']);
// Route::post('admin/login',[LoginController::class,'login'])->name('admin.login');
// Route::get('admin/logout',[LoginController::class,'logout']);

Route::group(['middleware' => 'isAdmin'], function (){

    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');
    Route::get('logout',[AuthController::class,'logout'])->name('logout');


    Route::get('/contents',[ContentController::class,'contents'])->name('contents');
    Route::get('/edit-content/{id}',[ContentController::class,'edit_content'])->name('edit-content');
    Route::post('/update-content',[ContentController::class,'update_content'])->name('update-content');


    Route::get('/users',[UserController::class,'users'])->name('users');
    Route::get('create-user',[UserController::class,'create_user'])->name('create-user');
    Route::post('/store-user',[UserController::class,'store_user'])->name('store-user');
    Route::get('/edit-user/{id}',[UserController::class,'edit_user'])->name('edit-user');
    Route::post('/update-user',[UserController::class,'update_user'])->name('update-user');
    Route::post('/delete-user',[UserController::class,'destroy_user'])->name('delete-user');
    
    Route::get('/show-deleted-users',[UserController::class,'show_deleted_users'])->name('show-deleted-user');
    Route::get('/restore-user/{id}',[UserController::class,'restore_user'])->name('restore-user');

    Route::get('/recruiters',[UserController::class,'company'])->name('recruiters');
    Route::get('create-recruiters',[UserController::class,'create_company'])->name('create-recruiters');
    Route::post('/store-recruiters',[UserController::class,'store_company'])->name('store-recruiters');
    Route::get('/edit-recruiters/{id}',[UserController::class,'edit_company'])->name('edit-recruiters');
    Route::post('/update-recruiters',[UserController::class,'update_company'])->name('update-recruiters');
    Route::post('/delete-recruiters',[UserController::class,'destroy_company'])->name('delete-recruiters');
    
    Route::get('/show-deleted-recruiters',[UserController::class,'show_deleted_recruiters'])->name('show-deleted-recruiters');
    


//Pitches
Route::get('/pitches',[PitchController::class,'index'])->name('pitches');
Route::get('/create-pitch',[PitchController::class,'create'])->name('create-pitch');
Route::post('/store-pitch',[PitchController::class,'store'])->name('store-pitch');
Route::get('/edit-pitch/{id}',[PitchController::class,'edit'])->name('edit-pitch');
Route::post('/update-pitch',[PitchController::class,'update'])->name('update-pitch');
Route::post('/delete-pitch',[PitchController::class,'destroy'])->name('delete-pitch');

//     Route::get('admin/dashboard',function()
//     {
//         return view('Admin.dashboard');        
//     });
//     Route::any('admin/settings', [AdminController::class,'myaccount']);
//     Route::get('dashboard-data', [AdminController::class,'dashboard'])->name('admin.dashboard');

//     Route::get('admin/users', [UserController::class,'index'])->name('admin.users');
//     Route::get('export', [UserController::class,'export'])->name('admin.users.export');

//     Route::get('admin/user/{id}',[UserController::class,'show']);
//     Route::get('admin/user/status/{id}', [UserController::class,'updateStatus']);

//     Route::get('admin/page/{name}',[PageController::class,'show']);
//     Route::post('admin/page/update',[PageController::class,'update'])->name('admin.page.update');

//     Route::get('admin/view-notification',[NotificationController::class, 'index'])->name('admin.view.notification');
//     Route::get('admin/send-notification',[NotificationController::class, 'view'])->name('admin.send.notification');
//     Route::post('admin/save-notification',[NotificationController::class, 'save'])->name('admin.save.notification');
//     Route::get('admin/admin-notifications',[NotificationController::class, 'adminNotifications'])->name('admin.admin.notification');
});