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

    public function button(Tools $tools)
    {
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$tools->get_access_token();
        $data=[
            "button"=>[
                [	
                     "type"=>"click",
                     "name"=>"今日歌曲",
                     "key"=>"V1001_TODAY_MUSIC"
                ],
                    [
                      "name"=>"菜单",
                      "sub_button"=>[
                      [	
                          "type"=>"view",
                          "name"=>"搜索",
                          "url"=>"http://www.soso.com/"
                      ],
                       [
                          "type"=>"click",
                          "name"=>"赞一下我们",
                          "key"=>"V1001_GOOD"
                       ]
                    ]
                  ]
              ]
        ]; 
        $re=$tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=\json_decode($re,true);
        echo createMenu($result);
        
    }
}

