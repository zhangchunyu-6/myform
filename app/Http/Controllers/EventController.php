<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class EventController extends Controller
{
    public function event(Tools $tools)
    {
      

        $info= file_get_contents("php://input");
        dd($info);
        file_put_contents(storage_path('logs/wechar/'.date('Y-m-d').'.log'),"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);

        file_put_contents(storage_path('logs/wechar/'.date('Y-m-d').'.log'),$info,FILE_APPEND);

        $xml_obj = simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);

        $xml_arr = (array)$xml_obj;
     
            if($xml_arr['MsgType']=='event' && $xml_arr['Event']=="subscribe"){
                $wechar_user = $tools->get_wechar_user($xml_arr['FromUserName']);
                
                $arr='你好'.$wechar_user['nickname'].',欢迎关注我!有福利';
                echo "<xml>
                <ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
                <FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
                <CreateTime>".$xml_arr['CreateTime']."</CreateTime>
                <MsgType><![CDATA[".$xml_arr['MsgType']."]]></MsgType>
                <Content><![CDATA[".$arr."]]></Content>
              </xml>";
            }
            //普通的信息发送
            if($xml_arr['MsgType']=='text'){
              
                $media_id="您好 新的一天又要开始了 你努力了吗？";
                echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
                <FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
                <CreateTime>".time()."</CreateTime>
                <MsgType><![CDATA[voice]]></MsgType>
                <Voice><MediaId><![CDATA[".$media_id."]]></MediaId></Voice>
                </xml>";
              }
              
  


              $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$tools->get_access_token();
              $data=[
                  "button"=>[
                      [	
                           "type"=>"click",
                           "name"=>"签到",
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
