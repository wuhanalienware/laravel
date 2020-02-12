<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    //关联的数据表
    public $table = 'category';
    //主键
    public $primaryKey = 'cate_id';
    //允许批量操作的字段单独指定
//    public $fillable = ['user_name'];
    //全部允许
    public $guarded = [];
    //是否维护created_at和updated_at
    public $timestamps = false;

    //    格式化分类数据
    public function tree()
    {
        //获取所有的分类数据
        $cates = $this->orderBy('cate_order', 'asc')->get();
        //格式化（排序、二级类缩进）
        return $this->getTree($cates);
    }

    public function getTree($category)
    {
        //排序
//        存放最终排完序的分类数据
        $arr = [];
//        先获取一级类
        foreach ($category as $k => $v) {
            //一级类
            if ($v->cate_pid == 0) {
                $arr[] = $v;
                //获取一级类下的二级类
                foreach ($category as $m => $n) {
                    if ($v->cate_id == $n->cate_pid) {
                        //给分类名称添加缩进
                        $n->cate_name = '|-----' . $n->cate_name;
                        $arr[] = $n;
                    }
                }
            }
        }
        return $arr;
    }

    //定义跟文章表的关联属性
    public function article()
    {
        return $this->hasMany('App\Model\Article', 'cate_id', 'cate_id');
    }
}
