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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'ChatController@login')->name('home');
Route::get('/test', function() {
  dd('sdf');
});

Route::get('/login', 'ChatController@login')->name('login');

Route::post('/chat', 'ChatController@chat')->name('chat');

Route::get('/test', 'ChatController@test')->name('test');

Route::resource('/rooms', 'RoomController');

Route::get('/setting_room/{id}', 'RoomController@setting_room')->name('setting_room');
Route::post('/setting_generate', 'RoomController@setting_generate')->name('setting_generate');
