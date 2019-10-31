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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
/*
 * Admin Auth Logic
 */
//Login & Logout
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login.submit');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.update');
Route::get('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.request');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

/**
 * Match Centre Routes
 */
Route::get('/match_centre/{type}', 'Matchday\MatchCentreController@index')->name('match_centre');
Route::get('/match_centre/data', 'Matchday\MatchCentreController@index')->name('match_centre.index');



/*
 * Admin Auth Logic
 */
Route::prefix('admin')->middleware(['web'])->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.home');
    /*
     * Team Routes
     */
    Route::get('/teams', 'Team\TeamController@index')->name('admin.teams');   
});
