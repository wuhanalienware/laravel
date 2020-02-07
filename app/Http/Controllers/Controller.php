<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    //返回正确或错误结果
    public function result($res)
    {
        if($res){
            $data = [
                'status'=>0,
                'msg'=>'操作成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'操作失败'
            ];
        }
        return $data;
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
