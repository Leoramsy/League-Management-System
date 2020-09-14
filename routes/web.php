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

//Auth::routes();

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
Route::prefix('match-centre')->group(function() {
    Route::get('/{type}', 'Matchday\MatchCentreController@index')->name('match-centre');
    Route::get('/data', 'Matchday\MatchCentreController@index')->name('match-centre.index');
});




/*
 * Admin Auth Logic
 */
Route::prefix('admin')->middleware(['web'])->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.home');
    Route::prefix('settings')->group(function() {
        /*
         * Team Routes
         */
        Route::get('/teams', 'Admin\Settings\TeamController@view')->name('admin.teams');
        Route::get('/teams/index', 'Admin\Settings\TeamController@index')->name('admin.teams.index');
        Route::post('/teams/add', 'Admin\Settings\TeamController@store')->name('admin.teams.store');
        Route::put('/teams/edit/{id}', 'Admin\Settings\TeamController@edit')->name('admin.teams.update');
        Route::delete('/teams/delete/{id}', 'Admin\Settings\TeamController@delete')->name('admin.teams.delete');

        /*
         * Season Routes
         */
        Route::get('/seasons', 'Admin\Settings\SeasonController@view')->name('admin.seasons');
        Route::get('/seasons/index', 'Admin\Settings\SeasonController@index')->name('admin.seasons.index');
        Route::post('/seasons/add', 'Admin\Settings\SeasonController@store')->name('admin.seasons.store');
        Route::put('/seasons/edit/{id}', 'Admin\Settings\SeasonController@edit')->name('admin.seasons.update');
        Route::delete('/seasons/delete/{id}', 'Admin\Settings\SeasonController@delete')->name('admin.seasons.delete');

        Route::prefix('leagues')->group(function() {
            /*
             * League Routes
             *          
             */
            Route::get('/', 'Admin\Settings\LeagueController@view')->name('admin.leagues');
            Route::get('/index', 'Admin\Settings\LeagueController@index')->name('admin.leagues.index');
            Route::post('/add', 'Admin\Settings\LeagueController@store')->name('admin.leagues.store');
            Route::put('/edit/{id}', 'Admin\Settings\LeagueController@edit')->name('admin.leagues.update');
            Route::delete('/delete/{id}', 'Admin\Settings\LeagueController@delete')->name('admin.leagues.delete');
            /*
             * League Format Routes
             *          
             */
            Route::get('/formats', 'Admin\Settings\LeagueFormatController@view')->name('admin.leagues.formats');
            Route::get('/formats/index', 'Admin\Settings\LeagueFormatController@index')->name('admin.leagues.formats.index');
            Route::post('/formats/add', 'Admin\Settings\LeagueFormatController@store')->name('admin.leagues.formats.store');
            Route::put('/formats/edit/{id}', 'Admin\Settings\LeagueFormatController@edit')->name('admin.leagues.formats.update');
            Route::delete('/formats/delete/{id}', 'Admin\Settings\LeagueFormatController@delete')->name('admin.leagues.formats.delete');
        });
    });
});
