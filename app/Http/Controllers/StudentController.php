<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class StudentController extends Controller
{


	public function char()
	{
	  $access_token = $this->get_access_token();
	  echo $access_token;
	}

	public function get_access_token()
	{
		$key="mechar_access_token";
		if(Cache::has($key)){
			//取缓存
			//return "从缓存中获取信息";
			$wechar_access_token=Cache::get($key);
		}else{
			//取不到 调接口
			$res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WECHAR_APPID').'&secret='.env('WECHAR_SECRET'));
			$result=json_decode($res,1);
			//dd($result);
			Cache::put($key,$result['access_token'],$result['expires_in']);
			$wechar_access_token =$result['access_token'];
		}

		return $wechar_access_token;
	}
   
}
