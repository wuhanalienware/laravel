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

//验证码路由2
Route::get('/code/captcha/{tmp}', 'LoginController@captcha');

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){
    //后台登陆页面路由
    Route::get('login','LoginController@login');
//验证码路由
    Route::get('code','LoginController@code');
//登陆处理路由
    Route::post('doLogin','LoginController@doLogin');
});


Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'isLogin'],function (){
    //后台首页
    Route::get('index','LoginController@index');
//后台欢迎页
    Route::get('welcome','LoginController@welcome');
//后台推出路由
    Route::get('logout','LoginController@logout');
    //删除多个用户操作
    Route::get('user/del','UserController@delAll');
//后台用户模块相关路由
    Route::resource('user','UserController');

});


//Route::get('admin/user/index','UserController@index');
