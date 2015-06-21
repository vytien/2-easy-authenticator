<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::controllers([
    'auth' => 'Bernardino\EasyAuthenticator\AuthController',
    'password' => 'Bernardino\EasyAuthenticator\PasswordController',
]);

Route::get(config('easyAuthenticator.login_page'), function() {
    return view('easyAuthenticator::login');
});

Route::get(config('easyAuthenticator.logout'), function() {
    return $this->app['authenticator']->logout();
});

Route::get(config('easyAuthenticator.login_redirect'), function() {
    $user = Bernardino\EasyAuthenticator\Models\User::find(\Auth::id());
    return view('easyAuthenticator::dashboard')->with('user', $user);
});

Route::get('easyAuth/{provider?}', function($provider = null) {
// 	var_dump($this);
// 	var_dump($this->app['authenticator']);
    return $this->app['authenticator']->login($provider);
});

Route::get('activate/{code}', 'bernardino\EasyAuthenticator\AuthController@accountIsActive');
