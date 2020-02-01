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
//
Route::get('/', function () {
    return view('welcome');
});
//Route::get('/', function () {
//    echo "hello";
//});
//用户添加路由
Route::get('user/add','UserController@add');
//用户执行添加路由
Route::post('user/store','UserController@store');
//显示用户列表页
Route::get('user/index','UserController@index');
//用户修改页面路由
Route::get('user/edit/{id}','UserController@edit');
//用户修改操作路由
Route::post('user/update','UserController@update');
//删除路由
Route::get('user/del/{id}','UserController@destory');
//登陆页面路由
Route::get('admin/login','Admin\LoginController@login');
//验证码路由
Route::get('admin/code','Admin\LoginController@code');
//验证码路由2
Route::get('/code/captcha/{tmp}', 'Admin\LoginController@captcha');
//登陆处理路由
Route::post('admin/doLogin','Admin\LoginController@doLogin');
