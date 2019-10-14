<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Tools\Tools;
class StudentController extends Controller
{


	

	

	public function index(Tools $tools)
	{
		$res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WECHAR_APPID').'&secret='.env('WECHAR_SECRET'));
		
		$result=json_decode($res);

		//获取token
		$token=$tools->get_access_token();
	    //dd($token);
		//获取openid 
		$openid=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$token.'&next_openid=');
		//dd($openid);
		$re=json_decode($openid,1);
		
		
		$openid_list=[];
	

        foreach ($re['data']['openid'] as $v)

        {
            $user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$tools->get_access_token().'&openid='.$v.'&lang=zh_CN');

            $res=json_decode($user_info,1);

            dd($res);

			$openid_list[]=$res;
	
        }
		//dd($openid_list);
		return view('wechar.user_list',['list'=>$openid_list]);
		
	}

	
	
	
}
