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
//没有权限跳转路由
Route::get('noaccess','Admin\LoginController@noaccess');

//后台推出路由
Route::get('admin/logout','Admin\LoginController@logout');

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['isLogin','hasRole']],function (){
//Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'isLogin'],function (){
    //后台首页
    Route::get('index','LoginController@index');
//后台欢迎页
    Route::get('welcome','LoginController@welcome');
    //删除多个用户操作
    Route::get('user/del','UserController@delAll');
//后台用户模块相关路由

    //为用户设置角色路由
    Route::get('user/user_auth/{id}','UserController@user_auth');
    //处理角色路由
    Route::post('user/doauth','UserController@doauth');
//    用户模块资源路由
    Route::resource('user','UserController');
    //角色模块
    //角色授权路由
    Route::get('role/auth/{id}','RoleController@auth');
    Route::post('role/doauth','RoleController@doauth');
    //    角色模块资源路由
    Route::resource('role','RoleController');

    //权限模块资源路由
    Route::resource('permission','PermissionController');

    //分类路由
    //    修改排序
    Route::post('cate/changeorder','CateController@changeOrder');
    Route::resource('cate','CateController');


    //    文章缩略图上传路由
    Route::post('article/upload','ArticleController@upload');
    //文章路由
    Route::resource('article','ArticleController');
});


//Route::get('admin/user/index','UserController@index');
