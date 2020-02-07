<?php

namespace App\Http\Middleware;

use App\Model\User;
use App\Model\Role;
use Closure;
use Illuminate\Routing\Route;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取当前请求的路由 对应的控制器方法名
//         "App\Http\Controllers\Admin\LoginController@index"
        $route =\Route::current()->getActionName();
//        dd($route);

        //获取当前用户的权限
        $user = User::find(session()->get('user')->user_id);
        //获取当前用户有哪些角色
        $roles = $user->role;
        //根据用户具有的角色获取权限
        $arr = [];
        foreach ($roles as $value) {
//            获取到的权限是不止一个所以需要遍历
            $pers = $value->permission;
            foreach ($pers as $per) {
                //将查到的全部路径放入数组
                $arr[] = $per->per_url;
            }
        }
//        dd($arr);
        //去掉重复的权限
        $arr = array_unique($arr);
        //判断当前路由是否有权限
        if(in_array($route,$arr)){
            return $next($request);
        } else {
            return redirect('noaccess');
        }

    }
}
