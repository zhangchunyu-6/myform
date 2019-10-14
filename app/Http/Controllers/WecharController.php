<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class WecharController extends Controller
{
    public function tag_user(Tools $tools,Request $request)
    {
        
        //1.获取用户信息 
        
        //2.接收给用户打标签所需要的id;
        $tag_id=$request->all();
      
        $url=('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$tools->get_access_token().'&next_openid=');
    
        $re=$tools->curl_get($url);
        
        $result=\json_decode($re,true);
       //dd($result);
        return view('wechar.user_list',['list'=>$result['data']['openid'],'tag_id'=>$request->input('tag_id')]);
    }
}

