<?php

namespace App\Http\Controllers\Admin;

use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *获取列表页
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //搜索加分页
        $user =  User::orderBy('user_id', 'asc')
            ->where(function ($query) use ($request) {
//                获取搜索条件
                $username = $request->input('username');
                $email = $request->input('email');
                //拼接查找条件
                if (!empty($username)){
                    $query->where('user_name','like','%'.$username.'%');
                }
                if (!empty($email)){
                    $query->where('email','like','%'.$email.'%');
                }
            })
            //分页
            ->paginate($request->input('num')?$request->input('num'):5);

//        $user = User::paginate(3);
        return view('admin.user.list',compact('user','request'));
    }


    /**
     * Show the form for creating a new resource.
     *返回用户添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *执行添加操作
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $input = $request->all();
        $username = $input['email'];
        $password = Crypt::encrypt($input['pass']); ;

        $res = User::create(['user_name'=>$username,'user_pass'=>$password,'email'=>$username]);
        $data = $this->result($res);
        return $data;
    }

    /**
     * Display the specified resource.
     *显示用户数据
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *返回修改页面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *执行修改操作
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $username = $request->input('username');
        $user->user_name = $username;
        $res = $user->save();
        $data = $this->result($res);
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *执行删除操作
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $res = $user->delete();
        $data = $this->result($res);
        return $data;
    }

    //删除所有选中用户
    public function delAll(Request $request)
    {
        $input = $request->input('ids');
        $res = User::destroy($input);
        $data = $this->result($res);
        return $data;
    }
    public function doauth(Request $request)
    {
        $input = $request->except('_token');
        //先删除全部权限
        DB::table('user_role')->where('user_id',$input['user_id'])->delete();
        //再添加新权限
        if (!empty($input['id'])){
            foreach ($input['id'] as $value) {
                DB::table('user_role')->insert(['user_id'=>$input['user_id'],'role_id'=>$value]);
            }
        }
        return redirect('admin/user');
    }
    //用户授权
    public function user_auth($id)
    {

        //获取当前用户
        $user = User::find($id);
        //获取所有的角色列表
        $perms = Role::get();
        //获取当前用户的角色
        //需要在模型中对角色表进行关联
        $own_perms = $user->role;
        //获取用户拥有的角色id
        $own_pers = [];
        foreach ($own_perms as $v) {
            $own_pers[] = $v->id;
        }
        return view('admin.user.auth',compact('user','perms','own_pers'));
    }
}
