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

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Request;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/ocr','OcrController@ocrEcho');
Route::get('/startOcr','OcrController@startOcr');


//user
Route::get('safePass', 'UserController@changePassword');
Route::get('changeInf', 'UserController@changeInf');
Route::get('tags', 'UserController@showTags');
Route::get('showUserUcUc', 'UserController@showUserUcUc');
Route::post('createTag', 'UserController@createTag');
Route::get('deleteTag/{id}', 'UserController@deleteTag');
Route::post('editTag', 'UserController@editTag');
Route::get('delUSerUcUc/{id}', 'UserController@delUSerUcUc');
Route::post('addUSerUcUc', 'UserController@addUSerUcUc');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/option', function (){
    return view('user/setting');
});
Route::get('/cropper', function (){
    return view('evidence/cropper');
});
Route::get('/addDoc', function (){
    return view('evidence/cropper');
});

//Roles
Route::get('/permsTest', 'PermissionsController@test');
Route::get('/role', 'PermissionsController@index')->name('role.index');
Route::get('/role/create', 'PermissionsController@create')->name('role.create');
Route::post('/role', 'PermissionsController@store')->name('role.store');
Route::get('/role/{role}/edit', 'PermissionsController@edit')->name('role.edit');
Route::put('/role/{role}', 'PermissionsController@update')->name('role.update');

//Admin
Route::get('/userAdmin', 'AdminController@selectUser');
Route::post('createUser','AdminController@createUser');
Route::post('deleteUser','AdminController@deleteUser');
Route::post('editUser','AdminController@editUser');
Route::get('userAddUc','AdminController@userAddUc');
Route::post('deleteUctoClient','AdminController@deleteUctoClient');
Route::post('addUserToUc','AdminController@addUserToUc');

//Tags
Route::resource('tags', TagController::class);
// Route::get('/tags/delete/{tag}', 'TagsController@destroy')->name('tags.destroy');
//[Remove] Route::get('/tags/sort/{sortby}/{ord?}', 'TagController@index')->name('tags.sort');

//Dokument
Route::get('/document', 'DocumentController@index')->name('document.index');
// Route::get('showPaperDate/delete/{id}', 'DokumentController@delDocument');
// Route::post('deleteProduct/{id}','DokumentController@deleteProduct');
// Route::post('changeBasicInfo/{id}','DokumentController@changeBasicInfo');
// Route::post('changeItems/{id}','DokumentController@changeItems');
// Route::post('addItem/{id}','DokumentController@addItem');
// Route::post('documentInfo/{id}','DokumentController@documentInfo');
// Route::get('delItem/{id}','DokumentController@delItem');
// Route::get('/active/{id}','DokumentController@active');
// Route::get('/deactive/{id}','DokumentController@deactive');
// //Route::post('search','DokumentController@search');
// Route::post('showPaperDate/searchUser','DokumentController@searchUser');
// Route::post('searchDate','DokumentController@searchUser');
// Route::post('searchFolder','DokumentController@searchFolder');
// Route::get('paperShow','DokumentController@getDocumentFolder');
// Route::get('showPaperDate/paper/{id}','DokumentController@paperIdShow');
// Route::post('addProduct/{id}','DokumentController@addProduct');
// Route::post('tagChange/{id}','DokumentController@tagChange');
// Route::post('tagUserShow','DokumentController@tagUserShow');
// Route::get('/editAfterSafe', 'DokumentController@editAfterSafe');
// Route::post('/safeDocument', 'DokumentController@safeDocument');
// Route::get('/showPaperDate/{date}', 'DokumentController@getDocumentMounth');

//image
Route::post('/images-save', 'UploadImage@store');
Route::post('/images-delete', 'UploadImage@destroy');
Route::get('/images-show', 'UploadImage@index');
Route::post('/safeImg', 'UploadImage@safeImg');


//ocr
Route::get('getdata','OcrController@getData');

//Mobil 

Route::get('loginMobil','MobilController@loginMobil');
Route::post('uploadSafeMobil','MobilController@uploadSafeMobil');
Route::post('upload','MobilController@uploadImage');
Route::get('dashboard','MobilController@dashboard');
