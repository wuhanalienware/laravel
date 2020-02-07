<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cate;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CateController extends Controller
{

    //修改排序
    public function changeOrder(Request $request)
    {
//        1. 获取传过来的参数
        $input = $request->except('_token');
        //2. 通过分类id获取当前分类
        $cate = Cate::find($input['cate_id']);
        //3. 修改当前分类的排序值
        $res = $cate->update(['cate_order'=>$input['cate_order']]);

        if($res){
            $data = [
                'status'=>0,
                'msg'=>'修改成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'修改失败'
            ];
        }

        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取分类数据
//        $cates = Cate::get();
        $cates = (new Cate())->tree();

        //返回分类页面
        return view('admin.cate.list',compact('cates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cate = Cate::where('cate_pid',0)->get();
        return view('admin.cate.add',compact('cate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //1. 接收添加的分类数据
        $input = $request->except('_token');
//        2. 表单验证

//        3. 添加到数据库中
        $res =  Cate::create($input);

//       4. 判断是佛添加成功
        $data = $this->result($res);
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //根据id获取要修改的用户
        $cate = Cate::findOrFail($id);
        return view('admin.cate.edit')->with('cate',$cate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //根据id,获取要修改的用户
        $cate = Cate::find($id);
        //将用户的相关属性修改为用户提交的值
        $input = $request->all();

        $res = $cate->update($input);

        if($res){
            $data = [
                'status'=>0,
                'msg'=>'修改成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'修改失败'
            ];
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = Cate::find($id);
        $res = $cate->delete();
        $data = $this->result($res);
        return $data;
    }
}
