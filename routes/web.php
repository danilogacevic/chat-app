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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware'=>'auth'],function(){

	Route::get('/home',function(){

		return view('home');
	});

	Route::get('/chat',function(){

		return view('chat');
	});

	Route::post('/chat','ChatController@search');
	Route::post('/messages','ChatController@messages');
	Route::post('/send','ChatController@send');
	Route::post('/typing','ChatController@whoIsTyping');
});




