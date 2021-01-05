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
        Route::middleware(['auth:api', 'scopes:USER'])->get('/users','App\Http\Controllers\AuthController@users');
        Route::get('/{id}/ratings','App\Http\Controllers\PostsController@ratings');
        Route::post('/upload','App\Http\Controllers\PostsController@uploadImage');
        Route::post('/{id}/ratings','App\Http\Controllers\PostsController@addRating');
    });


        Route::prefix("/user")->group(function(){
        Route::get('','App\Http\Controllers\AuthController@getUser');
        Route::put('','App\Http\Controllers\AuthController@updateUser');
        Route::get('/posts','App\Http\Controllers\PostsController@currentUserPosts');
        Route::delete('/posts/{id}','App\Http\Controllers\PostsController@destroy');
        Route::put('/posts/{id}','App\Http\Controllers\PostsController@update');
        Route::post('/posts','App\Http\Controllers\PostsController@store');
    });
        Route::get('/posts/{id}','App\Http\Controllers\PostsController@show');
        Route::get('user/categorii','App\Http\Controllers\AuthController@Categorii');
        Route::post('user/categorii','App\Http\Controllers\AuthController@addCategorii');
}
);


Route::prefix("/posts")->group(function(){
    Route::get('','App\Http\Controllers\PostsController@index');

});
Route::get('categories','App\Http\Controllers\CategoriiController@index');
Route::post('users/login','App\Http\Controllers\AuthController@Login');
Route::post('users/createRol','App\Http\Controllers\AuthController@createRol');
Route::post('users/register','App\Http\Controllers\AuthController@Register');

