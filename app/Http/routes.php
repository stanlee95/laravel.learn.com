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

Route::group(['middleware' => 'auth', 'as'=> 'auth'],function(){
    Route::get('/discuss','PostController@discuss');
    Route::post('/', 'PostController@post');
    Route::get('/deleteById/{id}', 'PostController@delete');
    Route::get('/view/{id}', 'PostController@viewPost');
    Route::get('/delete/{name}', 'PostController@deleteImage');
    Route::get('/deleteFile/{name}', 'PostController@deleteFile');
    Route::post('/uploadMoreFiles/{name}', 'PostController@uploadMoreFiles');
    Route::get('/response/{id}', 'PostController@response');
    Route::post('/response-post', 'PostController@responsePost');
    Route::get('/search-result', 'PostController@search');
    Route::get('/user-profile', 'UserController@index');
    Route::post('/user-profile/change', 'UserController@change');
    Route::post('/user-profile/status', 'UserController@status');

});

//-------------------------------Posts-------------------------------
Route::get('/','PostController@index');

//-------------------------------Category-------------------------------
Route::get('/category/{id}', 'CategoryController@index');
Route::get('/category/{id}/{parent_id}', 'CategoryController@sub');
//---------------Admin-panel------------------------------------

Route::group(['middleware'=>'admin', 'as'=> 'admin'],function(){
    Route::get('/admin-panel','AdminController@index');
    Route::get('admin-panel/user-profile','UserController@index');
    Route::get('admin-panel/users','AdminController@users');
    Route::post('admin-panel/users/status','AdminController@status');
    //Announcement
    Route::get('admin-panel/all-announcement','AdminController@allAnnouncement');
    Route::get('admin-panel/add-announcement','AdminController@addAnnouncement');
    Route::get('admin-panel/add','AdminController@addPostAnnouncement');
    Route::post('admin-panel/update-announcement','AdminController@updateAnnouncement');
    Route::get('admin-panel/delete-announcement/{id}','AdminController@deleteAnnouncement');
    Route::get('admin-panel/delete-response/{id}', 'AdminController@deleteResponse');
    //News
    Route::get('admin-panel/all-news','NewsController@index');
    Route::post('admin-panel/update-news','NewsController@update');
    Route::get('admin-panel/delete-news','NewsController@delete');
    //Projects
    Route::get('admin-panel/all-projects','ProjectController@index');
    Route::post('admin-panel/add-projects','ProjectController@edit');
    Route::get('admin-panel/delete-projects','ProjectController@delete');
    Route::get('admin-panel/get-project','ProjectController@getProject');
    Route::post('admin-panel/assign-projects','ProjectController@assign');
});


//------------------UserProfile------------------------------------
Route::post('/login', 'AuthController@login');

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/test', 'HomeController@cron');

//Route::get('/home', 'HomeController@index');
