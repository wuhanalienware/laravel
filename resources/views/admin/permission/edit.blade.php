<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>编辑权限</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  @include('admin/public/style')
  @include('admin/public/script')
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="x-body">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>权限名
                </label>
                <div class="layui-input-inline">
                    <input type="hidden" name="id" value="{{$per->id}}">
                    <input type="text" id="L_email" value="{{$per->per_name}}" name="per_name" required="" lay-verify=""
                           autocomplete="off" class="layui-input">
                </div>
                <label for="url" class="layui-form-label">
                    <span class="x-red">*</span>权限路由
                </label>
                <div class="layui-input-inline">
                    <input style="width: 500px;"  type="text" id="url" value="{{$per->per_url}}" name="per_url" required="" lay-verify=""
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>

          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="edit" lay-submit="">
                  修改
              </button>
          </div>
      </form>
        <script>
            layui.use(['form','layer'], function(){
                $ = layui.jquery;
                var form = layui.form
                    ,layer = layui.layer;

                //自定义验证规则
                form.verify({
                    nikename: function(value){
                        if(value.length < 5){
                            return '昵称至少得5个字符啊';
                        }
                    }
                    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
                    ,repass: function(value){
                        if($('#L_pass').val()!=$('#L_repass').val()){
                            return '两次密码不一致';
                        }
                    }
                });

                //监听提交
                form.on('submit(edit)', function(data){
                    var pid = $("input[name='id']").val();
                    $.ajax({
                        type:'PUT',
                        url:'/admin/permission/'+pid,
                        dataType:'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:data.field,
                        success: function (data) {
                            // console.log(data);
                            if (data.status == 0){
                                layer.alert(data.msg,{icon:6},function () {
                                    parent.location.reload(true);
                                });
                            }else {
                                layer.alert(data.msg,{icon:5})
                            }
                        },
                        error:function (data) {

                        }
                    });


                    // //发异步，把数据提交给php
                    // layer.alert("增加成功", {icon: 6},function () {
                    //     // 获得frame索引
                    //     var index = parent.layer.getFrameIndex(window.name);
                    //     //关闭当前frame
                    //     parent.layer.close(index);
                    // });
                    return false;
                });


            });
        </script>
    </div>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>
