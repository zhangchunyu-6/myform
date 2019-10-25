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

Route::get('/admin_create',function(){
        return view('admin.create');
});
Route::get('/wechar_login','LoginController@wechar_login');

Route::get('/wechar_code','LoginController@wechar_code');
Route::get('/wechar_index','LoginController@index');

//标签管理

Route::get('/tag_list','TagController@tag_list');
Route::any('/tag_add','TagController@tag_add');
Route::any('/tag_user_add','TagController@tag_user_add'); //给用户打标签
Route::any('/tag_del','TagController@Tag_del');
Route::any('/tag_edit','TagController@Tag_edit');
Route::any('/tag_update','TagController@Tag_update');
Route::any('/tag_user','WecharController@tag_user');
Route::any('/button','WecharController@button');//微信按钮
Route::any('/tag_sou','TagController@tag_sou');
//自动回复类
Route::any('/event','EventController@event');

//素材
Route::any('/resource','ResourceController@Resource');
Route::any('/wechar/uplod_do','ResourceController@upload_do');
Route::any('/wechar/resource_list','ResourceController@resource_list');//素材列表
Route::any('/clear_api','ResourceController@clear_api');
Route::any('/download','ResourceController@download');

//无限级分类
Route::any('/menu','MenuController@menu_create');
Route::any('/menu_do','MenuController@menu_do');
Route::any('/wechat_menu','MenuController@wechat_menu');
//考试
Route::any('/words','WordsController@words');
Route::any('/word_do','WordsController@word_do');
Route::any('/word_code','WordsController@word_code');


//二维码
Route::any('/wechar/list','ListController@wecharindex');
Route::any('/save_code','ListController@save_code');

//考试
Route::any('/Admin/create','AdminController@create');






