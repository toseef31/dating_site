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
Route::get('/','HomeController@main')->name('home')->middleware('logged');
Route::post('/','HomeController@postHome');
Route::get('/u/{username}','UserController@profile')->name('profile')->where('username','[a-z0-9-_]+');
Route::get('/photos/{username}','PhotoController@photos')->name('userphoto')->where('username','[a-z0-9-_]+');
Route::get('/page/{slug}','WelcomeController@main')->name('page')->where('username','[a-z-]+');
Route::get('login/facebook', 'UserController@facebook')->name('loginfacebook')->middleware('logged');
Route::post('login', 'HomeController@postHome')->name('login');
Route::get('login/facebook/callback', 'UserController@facebookcallback')->name('loginfacebookcallback')->middleware('logged');
Route::get('login/twitter', 'UserController@twitter')->name('logintwitter')->middleware('logged');
Route::get('login/twitter/callback', 'UserController@twittercallback')->name('logintwittercallback')->middleware('logged');
Route::get('register', 'UserController@register')->name('register')->middleware('logged');
Route::post('register', 'UserController@postRegister')->name('register')->middleware('logged');
Route::get('logout','UserController@logout')->name('logout');
Route::get('browse','HomeController@landing')->name('landing')->middleware('complete');
Route::post('register/quick','UserController@quickRegister')->name('quick_reg');
Route::middleware(['auth','complete'])->prefix('/')->group(function(){
    Route::post('upload/photo','PhotoController@upload')->name('upload_photo');
    Route::get('messages','MessageController@messages')->name('messages');
    Route::post('message/upload','MessageController@upload')->name('message_upload');
    Route::get('message/{id}','MessageController@message')->name('message');
    Route::get('video/{id}','MessageController@video')->name('video');
    Route::get('delete_message/{id}','MessageController@delete_message')->name('delete_message');
    Route::get('chat/{id}','MessageController@startChat')->name('chat');
    Route::get('call/{id}','MessageController@startcall')->name('call');
});
Route::get('user/setting','UserController@setting')->name('setting')->middleware('auth');
Route::post('user/setting','UserController@postSetting')->middleware('auth');
/*custome*/
Route::get('/custome','UserController@custome')->name('custome');
/*Ajax*/
Route::post('ajax', 'AjaxController@main')->name('ajax');
/*Admin*/
Route::get('admin/login', 'Admin\AuthController@login')->name('adminlogin');
Route::post('admin/login', 'Admin\AuthController@postLogin');
Route::middleware('admin')->prefix('admin')->group(function(){
    Route::get('logout', 'Admin\AuthController@logout')->name('adminlogout');
    Route::post('ajax', 'Admin\AjaxController@main')->name('adminajax');
    Route::get('/', 'Admin\HomeController@main')->name('adminhome');
    Route::get('setting', 'Admin\SettingController@main')->name('adminsetting');
    Route::post('setting', 'Admin\SettingController@saveSetting')->name('adminsetting');
    Route::get('interests', 'Admin\SettingController@interests')->name('admininterest');
    Route::get('get_users', 'Admin\HomeController@get_users');
    Route::get('get_users_weekly', 'Admin\HomeController@get_users_weekly');
    Route::get('get_users_monthly', 'Admin\HomeController@get_users_monthly');
    /*Users*/
    Route::get('users', 'Admin\UserController@main')->name('adminusers');
    Route::get('user/{id}', 'Admin\UserController@edit')->name('adminedituser');
    Route::post('user/{id}', 'Admin\UserController@updateUser')->name('adminedituser');
    Route::get('user/delete/{id}', 'Admin\UserController@deleteUser')->name('admindeleteuser');
    /*Page*/
    Route::get('pages', 'Admin\HomeController@pages')->name('adminpages');
    Route::get('page/add/{id?}', 'Admin\HomeController@addPage')->name('adminaddpage');
    Route::post('page/add/{id?}', 'Admin\HomeController@submitPage')->name('adminaddpage');
    Route::get('page/delete/{id}', 'Admin\HomeController@deletePage')->name('admindeletepage');
});
