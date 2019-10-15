<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class EventController extends Controller
{
    public function event(Tools $tools)
    {
      
        $info= file_get_contents("php://input");
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
                <MsgType><![CDATA['text']]></MsgType>
                <Content><![CDATA[".$arr."]]></Content>
              </xml>";
            }
            //普通的信息发送
            if($xml_arr['MsType']=='text'){
                $msg ="您好欢迎来到啥也不是公众号 感谢您的支持";
                echo "<xml>
                <ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
                <FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
                <CreateTime>".$xml_arr['CreateTime']."</CreateTime>
                <MsgType><![CDATA[".$xml_arr['MsgType']."]]></MsgType>
                <Content><![CDATA[".$msg."]]></Content>
                </xml>";
            }
     }     
                                                                                                                                       
}
