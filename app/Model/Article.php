<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //关联的数据表
    public $table ='article';
    //主键
    public $primaryKey ='art_id';
    //允许批量操作的字段单独指定
//    public $fillable = ['user_name'];
    //全部允许
    public $guarded = [];
    //是否维护created_at和updated_at
    public $timestamps = false;

    public function cate()
    {
        return $this->belongsTo('App\Model\Cate','cate_id','cate_id');
    }
}
