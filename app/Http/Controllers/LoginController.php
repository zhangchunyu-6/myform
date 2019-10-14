<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function wechar_login()
    {
       
        $redirect_uri=urlencode(env('APP_URL').'/wechar_code');
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAR_APPID').'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
            // dd($url); 
        header('location:'.$url);
        
    }

    /* 
     获取code 然后用code换取token;

    */
    public function code(Request $request)
    {
        $code=Request()->all();
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAR_APPID').'&secret='.env('WECHAR_SECRET').'&code='.$code['code'].'&grant_type=authorization_code';

        $re=file_get_contents($url);
        //必须携带第二个参数
          $result=json_decode($re,true);
          echo "<pre>";
        print_r($result); 
    }
}
