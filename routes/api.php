<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
   // return $request->user();
//});
Route::group(['middleware'=>'auth:api'],function (){
    Route::prefix("/posts")->group(function(){
        Route::post('','App\Http\Controllers\PostsController@store');
        Route::middleware(['auth:api', 'scopes:USER'])->get('/users','App\Http\Controllers\AuthController@users');
    });
}
);


Route::prefix("/posts")->group(function(){

    Route::get('','App\Http\Controllers\PostsController@index');
    Route::get('/{id}','App\Http\Controllers\PostsController@show');

});
Route::post('users/login','App\Http\Controllers\AuthController@Login');
Route::post('users/createRol','App\Http\Controllers\AuthController@createRol');
Route::post('users/register','App\Http\Controllers\AuthController@Register');

