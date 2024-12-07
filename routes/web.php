<?php

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
//use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\MasterSelectController;
use App\Http\Controllers\NotificationController;
use Carbon\Carbon;

//Auth::routes();

Route::get('admin/dashboard', function () {
    return redirect('admin/welcome');
});

Route::post('admin/login', 'Auth\LoginController@loginWithOtp')->name('login');
Route::get('admin/resend-otp', 'Auth\LoginController@sendOtp');
Route::post('admin/verify-otp', 'Auth\LoginController@verifyOtp');
Route::get('admin/edit-account-info', 'Auth\MyAccountController@getAccountInfoForm')->name('backpack.account.info');
Route::get('admin/edit-account-password', 'Auth\MyAccountController@getChangePasswordForm')->name('backpack.account.password');
Route::post('admin/edit-account-info', 'Auth\MyAccountController@postAccountInfoForm');
Route::post('admin/edit-account-password', 'Auth\MyAccountController@postChangePasswordForm');
Route::get('admin/change-password', 'Auth\MyAccountController@getChangePasswordForm');
Route::post('admin/change-password', 'Auth\MyAccountController@postChangePasswordForm');
Route::get('/', function () {
    $response = ['error' => 'Unauthorized', 'message' => 'Incorrect username or password'];

    return redirect()->to('/admin');
});

Route::get('home', function () {
    return redirect()->to('/admin');
});

Route::group([
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
], function () { // custom admin routes
    Route::get('/sso', 'Api\SsoController@sso_authorize');
    Route::get('/auth/callback', 'Api\SsoController@callback');
});

Route::group([
    'prefix' => 'notification',
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
], function () {
    Route::get('notif-badges', [NotificationController::class, 'getNotifBadges']);
});

/**
 * Master data route
 */

Route::group([
    'prefix' => 'master',
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
], function () {
});



