<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Tools\Tools;
class StudentController extends Controller
{


	public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

	

	 public function index(Request $request,Tools $tools)

    {

		$token=$this->tools->get_access_token();
		//dd($token);

//        获取openid

        $openid=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$token.'&next_openid=');

        $re=json_decode($openid,1);

    // dd($re);

        $openid_list=[];

        foreach ($re['data']['openid'] as $v)

        {

//            获取用户基本信息

            $user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_access_token().'&openid='.$v.'&lang=zh_CN');

            $res=json_decode($user_info,1);

//            dd($res);

            $openid_list[]=$res;

        }

      // dd($openid_list);

        return view('wechar.user_list_do',['list'=>$openid_list]);

    }

	
	
	
}
