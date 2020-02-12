<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //关联的数据表
    public $table ='config';
    //主键
    public $primaryKey ='conf_id';
    //允许批量操作的字段单独指定
//    public $fillable = ['user_name'];
    //全部允许
    public $guarded = [];
    //是否维护created_at和updated_at
    public $timestamps = false;
}
