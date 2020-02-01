<?php

namespace App\Http\Controllers;



use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //添加页面
    public function add()
    {
        return view("user.add");
    }
//执行用户添加操作
    public function store(Request $request)
    {
        $input = $request->except('_token');
//        dd($input);
        $input['password'] = md5($input['password']);
//        'username'=>$input['username']
        $res = User::create($input);
        if ($res){
            return redirect('user/index');
        }else {
            return back();
        }
    }
//用户列表页
    public function index()
    {
        $user = User::get();
        return view('user.list')->with('user',$user);
    }
//修改页面
    public function edit($id)
    {
        //根据路由传过来的id查找数据
        $user = User::find($id);
        //跳转页面并且传递user值到前端
        return view('user.edit',compact('user'));
    }
//修改操作
    public function update(Request $request)
    {
        //接收用户名和id
        $input = $request->all();
        $user = User::find($input['id']);
        $res = $user->update(['username'=>$input['username']]);
        if ($res){
            return redirect('user/index');
        }else{
            return back();
        }

    }
//用户删除
    public function destory($id)
    {
        $user = User::find($id);
        $res = $user->delete();
        if($res){
            $data = [
                'status'=>0,
                'msg'=>'删除成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'删除失败'
            ];
        }
        return $data;
    }

}
