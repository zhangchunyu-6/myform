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

Route::any('/char','StudentController@char');
Route::get('/index','StudentController@index');



Route::get('/login',function(){
    return view('login');
});
Route::get('/wechar_login','LoginController@wechar_login');
Route::get('/wechar_code','LoginController@code');
Route::get('/wechar_index','LoginController@index');

//标签管理

Route::get('/tag_list','TagController@tag_list');
Route::any('/tag_add','TagController@tag_add');
Route::any('/tag_user_add','TagController@tag_user_add'); //给用户打标签
Route::any('/tag_del','TagController@Tag_del');
Route::any('/tag_edit','TagController@Tag_edit');
Route::any('/tag_update','TagController@Tag_update');
Route::any('/tag_user','WecharController@tag_user');
Route::any('/tag_sou','TagController@tag_sou');

Route::any('/event','EventController@event');




