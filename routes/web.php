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


