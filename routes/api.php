<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});

Route::group(['middleware' => 'cors'], function () {
    Route::post('/tests/getlist', 'Tests\TestsController@getTestsList');
    Route::get('/categories/getlist', 'Categories\CategoriesController@getCategoriesList');
    Route::post('/categories/getmeta', 'Categories\CategoriesController@getCategoriesMeta');
    Route::get('/test/{id}',  'Tests\TestsController@getTest');
    Route::post('/tests/getmore', 'Tests\TestsController@getMore');
    Route::post('/test/getmeta', 'Tests\TestsController@getTestMeta');
    Route::post('/test/gettoplist',  'Tests\TestsController@getTopTests');
    Route::post('/tests/getresults', 'Results\ResultsController@getResult');
    Route::post('/search', 'Search\SearchController@getSearchResult');
});