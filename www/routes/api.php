<?php

use Illuminate\Http\Request;

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

//Users
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Permissions
Route::get('permissions', 'Api\PermissionController@getAllPermissions');
Route::get('permissions/{role}', 'Api\PermissionController@getRole');

//Tags
Route::get('tags/{tag}', 'Api\TagController@getTag');
Route::get('tags/getFgColor/{bgColor}', 'Api\TagController@getFgColor');
