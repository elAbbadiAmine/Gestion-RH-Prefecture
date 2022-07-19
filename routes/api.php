<?php

use Illuminate\Http\Request;

/*php
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['user' => 'API\UserController']);
Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');
Route::get('division','API\DivisionController@index');
Route::post('division','API\DivisionController@store');
Route::get('UserDivisions','API\DivisionController@UserDivisions');
Route::get('loadDivs','API\UserController@loadDivs');
Route::put('division/{id}', 'API\DivisionController@update');
Route::get('service','API\ServController@index');
Route::get('getServices/{id}','API\ServController@getServices');
Route::get('divIndex/{id}','API\ServController@divIndex');
Route::post('service','API\ServController@store');
Route::get('UserServices','API\ServController@UserServices');
Route::delete('division/{id}','API\DivisionController@destroy');
Route::get('division/{id}','API\DivisionController@show');
Route::delete('service/{id}','API\ServController@destroy');
Route::put('service/{id}', 'API\ServController@update');
Route::get('ServDivision','API\ServController@ServDivision');

// les demandes
Route::post('demande_conge','API\DemandeCongeController@store');
Route::get('loadDemandeConge','API\DemandeCongeController@index');

Route::get('loadDemandeCongeChef','API\DemandeCongeControllerChef@index');

Route::get('loadDemandeCongeAll','API\DemandeCongeAllController@index');

Route::get('loadDemandeRhAll','API\DemandeRhAllController@index');

Route::post('demande_rh','API\DemandeRhController@store');
Route::get('loadDemandeRh','API\DemandeRhController@index');

Route::get('loadDemandeRhChef','API\DemandeRhChefController@index');