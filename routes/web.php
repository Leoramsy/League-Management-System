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
Route::get('/data', 'HomeController@data')->name('data');
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

Route::get('/teams', function() {
    return view("client.coming_soon");
});

Route::get('/players', function() {
    return view("client.coming_soon");
});

Route::get('/about-us', function() {
    return view("client.coming_soon");
});

Route::get('/news', function() {
    return view("client.coming_soon");
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

        /*
         * Player Routes
         */
        Route::get('/players', 'Admin\Settings\PlayerController@view')->name('admin.players');
        Route::get('/players/index', 'Admin\Settings\PlayerController@index')->name('admin.players.index');
        Route::post('/players/add', 'Admin\Settings\PlayerController@store')->name('admin.players.store');
        Route::put('/players/edit/{id}', 'Admin\Settings\PlayerController@edit')->name('admin.players.update');
        Route::delete('/players/delete/{id}', 'Admin\Settings\PlayerController@delete')->name('admin.players.delete');
        Route::post('/players/image', 'Admin\Settings\PlayerController@image')->name('admin.players.image');

        /*
         * Fixtures Routes
         */
        Route::get('/fixtures', 'Admin\Matchday\FixtureController@view')->name('admin.fixtures');
        Route::get('/fixtures/index', 'Admin\Matchday\FixtureController@index')->name('admin.fixtures.index');
        Route::post('/fixtures/add', 'Admin\Matchday\FixtureController@store')->name('admin.fixtures.store');
        Route::put('/fixtures/edit/{id}', 'Admin\Matchday\FixtureController@edit')->name('admin.fixtures.update');
        Route::delete('/fixtures/delete/{id}', 'Admin\Matchday\FixtureController@delete')->name('admin.fixtures.delete');
        // AJAX route
        Route::get('/fixtures/data/{id}', 'Admin\Matchday\FixtureController@data')->name('admin.fixtures.data');

        /*
         * MatchDay Routes
         */
        Route::get('/match_days', 'Admin\Matchday\MatchDayController@view')->name('admin.match_days');
        Route::get('/match_days/index', 'Admin\Matchday\MatchDayController@index')->name('admin.match_days.index');
        Route::post('/match_days/add', 'Admin\Matchday\MatchDayController@store')->name('admin.match_days.store');
        Route::put('/match_days/edit/{id}', 'Admin\Matchday\MatchDayController@edit')->name('admin.match_days.update');
        Route::delete('/match_days/delete/{id}', 'Admin\Matchday\MatchDayController@delete')->name('admin.match_days.delete');


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
    /*
     * News Routes
     *          
     */
    Route::prefix('news')->group(function() {
        Route::get('/', 'Admin\Settings\NewsController@view')->name('admin.news');
        Route::get('/index', 'Admin\Settings\NewsController@index')->name('admin.news.index');
        Route::post('/add', 'Admin\Settings\NewsController@store')->name('admin.news.store');
        Route::put('/edit/{id}', 'Admin\Settings\NewsController@edit')->name('admin.news.update');
        Route::delete('/delete/{id}', 'Admin\Settings\NewsController@delete')->name('admin.news.delete');
    });
});
