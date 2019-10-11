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

    public function code(Request $request)
    {
        $code=Request()->all();
        dd($code);
    }
}
