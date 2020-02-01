<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Org\code\Code;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    //后台登录页
    public function login()
    {
        return view('admin.login');
    }
    //处理后台登陆
    public function doLogin(Request $request)
    {
        //获取用户信息
        $input = $request->except('_token');
        //验证登陆信息
        $rule = [
            'username'=>'required|between:4,18',
            'password'=>'required|between:4,18|alpha_dash',
        ];
        $msg = [
            'username.required'=>'用户名不能为空',
            'username.between'=>'用户长度必须在4-18位之间',
            'password.required'=>'密码不能为空',
            'password.between'=>'密码长度必须在4-18位之间',
            'password.alpha_dash'=>'密码必须是数字字母下划线',
        ];
        $validator = Validator::make($input,$rule,$msg);
        //返回错误信息
        if ($validator->fails()){
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }

        //对比数据库是否有此用户
        //验证验证码
        if(strtolower($input['code']) != strtolower(session()->get('code'))){
            return redirect('admin/login')->with('errors', '验证码错误');
        }
        //验证用户名
        $user = User::where('user_name',$input['username'])->first();
        if (!$user) {
            return redirect('admin/login')->with('errors', '没有此用户');
        }
//        验证密码
        if ($input['password'] != Crypt::decrypt($user->user_pass)) {
            return redirect('admin/login')->with('errors','密码错误');

        }
//        $a = '123456';
//        $crpty = 'eyJpdiI6IjduWEFYc1NreVo2RTVcL0g0QlFuUkVnPT0iLCJ2YWx1ZSI6InJoT1RcL2RkSE9QeWcrOVBrZEpJdk93PT0iLCJtYWMiOiI3NzI5OGEzZDIyNmJjNzUwMDQxY2MwNzM4ZjVkNmQwOWY2OTRjMTlhNzQ2NGU4NGJiNzkyOTY1OTlkNGI2MGY1In0=';
////        return $crypt = Crypt::encrypt($a);
//        if (Crypt::decrypt($crpty) == $a) {
//            return '密码正确';
//        }
        //保存用户信息到session中
        session()->put('user',$user);
        //跳转到后台首页
        return redirect('admin/index');
    }


    //验证码1
    public function code()
    {
        $code = new code();
        return $code->make();
    }

// 验证码2生成
    public function captcha($tmp)
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(6);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
        \Session::flash('code', $phrase);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }
//后台首页
    public function index()
    {
        return view('admin.index');
}//后台欢迎页
    public function welcome()
    {
        return view('admin.welcome');
}

//推出后台登陆
    public function logout()
    {
        //清空后台session
        session()->flush();
        return redirect('admin/login');
}
}
