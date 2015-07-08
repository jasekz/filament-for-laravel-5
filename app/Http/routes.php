<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */

/*
 * |--------------------------------------------------------------------------
 * | Auth
 * |--------------------------------------------------------------------------
 * |
 */
Route::get('admin/login', [
    'as' => 'admin.auth.login',
    'uses' => 'Admin\AuthController@getLogin'
]);
Route::post('admin/login', [
    'as' => 'admin.auth.login',
    'uses' => 'Admin\AuthController@postLogin'
]);
Route::get('admin/logout', [
    'as' => 'admin.auth.logout',
    'uses' => 'Admin\AuthController@getLogout'
]);
Route::get('admin/forgot-password', [
    'as' => 'admin.password.forgot_password',
    'uses' => 'Admin\PasswordController@getEmail'
]);
Route::post('admin/forgot-password', [
    'as' => 'admin.password.forgot_password',
    'uses' => 'Admin\PasswordController@postEmail'
]);
Route::get('admin/reset-password/{token}', [
    'as' => 'admin.password.reset_password',
    'uses' => 'Admin\PasswordController@getReset'
]);
Route::post('admin/reset-password/{token}', [
    'as' => 'admin.password.reset_password',
    'uses' => 'Admin\PasswordController@postReset'
]);


/*
 * |--------------------------------------------------------------------------
 * | Dashboard
 * |--------------------------------------------------------------------------
 * |
 */
Route::get('/', function()
{
    return redirect(route('admin.dashboard'));
});
Route::get('/admin', function()
{
    return redirect(route('admin.dashboard'));
});
Route::get('admin/dashboard', [
    'as' => 'admin.dashboard',
    'uses' => 'Admin\DashboardController@index'
]);

/*
 * |--------------------------------------------------------------------------
 * | Admin
 * |--------------------------------------------------------------------------
 * |
 */
Route::group(['prefix' => 'admin'], function () {
    Route::resource('account', 'Admin\MyAccountController');
});
/*
 * |--------------------------------------------------------------------------
 * | Users
 * |--------------------------------------------------------------------------
 * |
 */
Route::group(['prefix' => 'admin'], function () {
    Route::resource('users', 'Admin\UserController');
    Route::resource('roles', 'Admin\RoleController');
    Route::resource('permissions', 'Admin\PermissionController');
});
