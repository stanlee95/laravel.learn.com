<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
//

//-------------------------------Posts-------------------------------
Route::get('/','PostController@index');
Route::post('/', 'PostController@post');
Route::get('/deleteById/{id}', 'PostController@delete');
Route::get('/view/{id}', 'PostController@viewPost');
Route::get('/delete/{name}', 'PostController@deleteImage');
Route::get('/deleteFile/{name}', 'PostController@deleteFile');
Route::post('/uploadMoreFiles/{name}', 'PostController@uploadMoreFiles');
Route::get('/response/{id}', 'PostController@response');
Route::post('/response-post', 'PostController@responsePost');
Route::get('/search-result', 'PostController@search');
//-------------------------------Category-------------------------------
Route::get('/category/{id}', 'CategoryController@index');
Route::get('/category/{id}/{parent_id}', 'CategoryController@sub');
//---------------Admin-panel------------------------------------

Route::group(['middleware'=>'admin', 'as'=> 'admin'],function(){
    Route::get('/admin-panel','AdminController@index');
    Route::get('admin-panel/user-profile','UserController@index');
    Route::get('admin-panel/users','AdminController@users');
    //Caregory
    Route::get('admin-panel/all-category','AdminController@allCategory');
    Route::get('admin-panel/add-category','AdminController@addCategory');
    Route::get('admin-panel/delete-category/{id}','AdminController@deleteCategory');
    Route::post('admin-panel/add-category','AdminController@addCategory');
    //Announcement
    Route::get('admin-panel/all-announcement','AdminController@allAnnouncement');
    Route::get('admin-panel/add-announcement','AdminController@addAnnouncement');
    Route::get('admin-panel/add','AdminController@addPostAnnouncement');
    Route::post('admin-panel/update-announcement','AdminController@updateAnnouncement');
    Route::get('admin-panel/delete-announcement/{id}','AdminController@deleteAnnouncement');
    Route::get('admin-panel/delete-response/{id}', 'AdminController@deleteResponse');
});


//------------------UserProfile------------------------------------
Route::get('/user-profile', 'UserController@index');
Route::post('/user-profile/change', 'UserController@change');

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/test', 'HomeController@cron');

//------LoGin with socials-----------------------------------------
Route::get('facebookLogin', 'Auth\AuthController@facebookLogin');
Route::get('facebookCallback', 'Auth\AuthController@facebookCallback');

Route::get('email-check', 'Auth\AuthController@callbackEmailCheck');
Route::post('email-save', 'Auth\AuthController@callbackEmailSave');


Route::get('googleLogin', 'Auth\AuthController@googleLogin');
Route::get('googleCallback', 'Auth\AuthController@googleCallback');

Route::get('yandexLogin', 'Auth\AuthController@yandexLogin');
Route::get('yandexCallback', 'Auth\AuthController@yandexCallback');

Route::get('mailruLogin', 'Auth\AuthController@mailruLogin');
Route::get('mailruCallback', 'Auth\AuthController@mailruCallback');

Route::get('odnoLogin', 'Auth\AuthController@odnoLogin');
Route::get('odnoCallback', 'Auth\AuthController@odnoCallback');
//-------------------------------------------------------------------
//Route::get('/home', 'HomeController@index');
