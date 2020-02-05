<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //关联的数据表
    public $table ='role';
    //主键
    public $primaryKey ='id';
    //允许批量操作的字段单独指定
//    public $fillable = ['user_name'];
    //全部允许
    public $guarded = [];
    //是否维护created_at和updated_at
    //是否往数据库添加创建时间和更新时间，数据库需要有对应字段create_at,update_at
//    public $timestamps = false;
    public function permission()
    {
        return $this->belongsToMany('App\Model\Permission','role_permission','role_id','permission_id');
    }
//
}
