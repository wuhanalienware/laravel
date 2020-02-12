<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Redis;
use Intervention\Image\Facades\Image;
use App\Model\Article;
use App\Model\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Facades\Storage;


class ArticleController extends Controller
{
    //将markdown语法转化为html内容
    public function pre_mk(Request $request){

       return Markdown::convertToHtml($request->cont);
    }

    public function upload(Request $request)
    {
        //获取上传文件
        $file = $request->file('photo');//photo是前端文件上传input的类名
        if(!$file->isValid()){
            return response()->json(['ServerNo'=>'400', 'ResultData' => '无效的上传文件',]);
        }
        //获取原文件的扩展名
        $ext = $file->getClientOriginalExtension();    //文件拓展名

        //新文件名
        $newfile = md5(time().rand(1000,9999)).'.'.$ext;
        //指定文件上传的目录
        $path = public_path('uploads');

        //将文件从临时目录移动到本地指定目录(原始方法)
//        if(! $file->move($path,$newfile)){
//            return response()->json(['ServerNo'=>'400','ResultData'=>'保存文件失败']);
//        }

        //（使用Image插件）
//        $res = Image::make($file)->resize(100,100)->save($path.'/'.$newfile);
//        if($res){
//            return response()->json(['ServerNo'=>'200','ResultData'=>$newfile]);
//        }else{
//            return response()->json(['ServerNo'=>'400','ResultData'=>'保存文件失败']);
//        }
        //使用七牛云
//          $qiniu = Storage::disk('qiniu');

        $res = Storage::disk('qiniu')->writeStream($newfile, fopen($file->getRealPath(), 'r'));


//        $res = Image::make($file)->resize(100,100)->save($path.'/'.$newfile);

        if($res){
            // 如果上传成功
            return response()->json(['ServerNo'=>'200','ResultData'=>$newfile]);
        }else{
            return response()->json(['ServerNo'=>'400','ResultData'=>'上传文件失败']);
        }
        }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //定义一个变量，存放所有的文章记录
//        $arts = Article::orderBy('art_id', 'asc')->paginate(5);
        $arts = [];

        $listkey = 'LIST:ARTICLE';
        $hashkey = 'HASH:ARTICLE:';
//        redis中存在要取的文章
        if(Redis::exists($listkey)){
            //存放所有要获取文章的id
            $lists = Redis::lrange($listkey,0,-1);

            foreach ($lists as $k=>$v){
                $arts[] = Redis::hgetall($hashkey.$v);
            }

        }else{
//            1. 链接mysql数据库，获取需要的数据
            $arts = Article::get()->toArray();
//            2. 将数据存入redis
            foreach ($arts as $k=>$v){
                //将文章的id添加到listkey变量中
                Redis::rpush($listkey,$v['art_id']);
//                将文章添加到hashkey变量中
                Redis::hmset($hashkey.$v['art_id'],$v);
            }
//            3. 返回数据给客户端
        }

//        dd($arts);


        return view('admin.article.list',compact('arts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取所有分类
        $cates = (new Cate())->tree();
        return view('admin.article.add',compact('cates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $listkey = 'LIST:ARTICLE';
        $hashkey = 'HASH:ARTICLE:';

        $input = $request->except('_token','photo');
        //添加时间
        $input['art_time'] = time();
        $input['art_view'] = 0;
        $input['art_status'] = 0;

        // 将提交的文章数据保存到数据库

        $res = Article::create($input);

        if($res){
//            如果添加成功，更新redis
            Redis::rpush($listkey,$res->art_id);
            Redis::hMset($hashkey.$res->art_id,$res->toArray());

            return redirect('admin/article');
        }else{
            return back();
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Article::find($id)->delete();
        //如果删除成功
        if($res){
//            Redis::flushdb();
            $data = [
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'删除失败'
            ];
        }

        return $data;
    }
}
