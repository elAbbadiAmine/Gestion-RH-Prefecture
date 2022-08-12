<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('division/getByName/{nom}','API\DivisionController@getDivsByName');



Route::get('getByDate/{dateFrom}/{dateTo}','API\UserController@getUsersByDate');

Route::get('getByName/{nom}','API\UserController@getUsersByName');

Route::get('getByType/{type}','API\UserController@getUsersByType');

Route::get('getByDivision/{id}','API\UserController@getUsersByDiv');







/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/// DEMANDE DE CONGÉ
Route::post('demande_conge','API\DemandeCongeController@store');
Route::delete('demande_conge/{id}','API\DemandeCongeController@destroy');


/// DEMANDE DE Doc RH
Route::post('demande_rh','API\DemandeRhController@store');
Route::delete('demande_rh/{id}','API\DemandeRhController@destroy');


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/// LISTE DES DEMANDES DE CONGÉS (admin)
Route::get('loadDemandeCongeAll','API\DemandeCongeAllController@index');
Route::get('listeDemandes/demande_conge/byName/{nom}','API\DemandeCongeAllController@getByName');
Route::get('listeDemandes/demande_conge/byType/{type}','API\DemandeCongeAllController@getByType');
Route::get('listeDemandes/demande_conge/byDate/{dateFrom}/{dateTo}','API\DemandeCongeAllController@getByDate');

/// LISTE DES DEMANDES DE CONGÉS (chef de division)
Route::get('loadDemandeCongeChef','API\DemandeCongeControllerChef@index');
Route::get('listeDemandesDivision/demande_conge/byName/{nom}','API\DemandeCongeControllerChef@getByName');
Route::get('listeDemandesDivision/demande_conge/byType/{type}','API\DemandeCongeControllerChef@getByType');
Route::get('listeDemandesDivision/demande_conge/byDate/{dateFrom}/{dateTo}','API\DemandeCongeControllerChef@getByDate');

/// MES DEMANDE DE CONGÉS
Route::get('loadDemandeConge','API\DemandeCongeController@index');
Route::get('mesDemandes/demande_conge/byType/{type}','API\DemandeCongeController@getByType');
Route::get('mesDemandes/demande_conge/byDate/{dateFrom}/{dateTo}','API\DemandeCongeController@getByDate');


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/// LISTE DES DEMANDES DE Doc RH (admin)
Route::get('loadDemandeRhAll','API\DemandeRhAllController@index');
Route::get('listeDemandes/demande_rh/byName/{nom}','API\DemandeRhAllController@getByName');
Route::get('listeDemandes/demande_rh/byType/{type}','API\DemandeRhAllController@getByType');
Route::get('listeDemandes/demande_rh/byLangue/{langue}','API\DemandeRhAllController@getByLangue');

/// LISTE DES DEMANDES DE Doc RH (chef de division)
Route::get('loadDemandeRhChef','API\DemandeRhChefController@index');
Route::get('listeDemandesDivision/demande_rh/byName/{nom}','API\DemandeRhChefController@getByName');
Route::get('listeDemandesDivision/demande_rh/byType/{type}','API\DemandeRhChefController@getByType');
Route::get('listeDemandesDivision/demande_rh/byLangue/{langue}','API\DemandeRhChefController@getByLangue');

/// MES DEMANDE DE Doc RH
Route::get('mesDemandes/demande_rh/loadDemandeRh','API\DemandeRhController@index');
Route::get('mesDemandes/demande_rh/byType/{type}','API\DemandeRhController@getByType');
Route::get('mesDemandes/demande_rh/byLangue/{langue}','API\DemandeRhController@getByLangue');



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/// GESTION ETAT
Route::get('getCongeEtat/{idConge}','API\DemandeCongeController@getEtat');
Route::post('setCongeEtat/{idConge}/{idEtat}','API\DemandeCongeController@setEtat');



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/// Gestion SOLDE 
Route::post('setNewSolde/{idConge}/{nbJours}','API\UserController@setSolde');
Route::get('getSolde/{id}','API\DemandeCongeController@getSoldeByConge');




Route::get('getSolde','API\UserController@getSolde');



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//Route::get('pdfview/',array('as'=>'pdfview','uses'=>'ItemController@pdfview'));  
