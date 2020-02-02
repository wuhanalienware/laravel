<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *获取列表页
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user =  User::orderBy('user_id', 'asc')
            ->where(function ($query) use ($request) {
                $username = $request->input('username');
                $email = $request->input('email');
                if (!empty($username)){
                    $query->where('user_name','like','%'.$username.'%');
                }
                if (!empty($email)){
                    $query->where('email','like','%'.$email.'%');
                }
            })
            ->paginate($request->input('num')?$request->input('num'):3);

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
        if($res){
            $data = [
                'status'=>0,
                'msg'=>'添加成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'添加失败'
            ];
        }
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
        if ($res) {
            $data = [
                'status'=>0,
                'msg' => '修改成功',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg' => '修改失败',
            ];
        }
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
        if ($res) {
            $data = [
                'status'=>0,
                'msg' => '删除成功',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg' => '删除失败',
            ];
        }
        return $data;
    }

    //删除所有选中用户
    public function delAll(Request $request)
    {
        $input = $request->input('ids');
        $res = User::destroy($input);
        if ($res) {
            $data = [
                'status'=>0,
                'msg' => '删除成功',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg' => '删除失败',
            ];
        }
        return $data;
    }
}
