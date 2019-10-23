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

           if($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'subscribe'){
               $wechar_user = $tools->get_wechar_user($xml_arr['FromUserName']);
               $msg = '欢迎'.$wechar_user['nickname'].'同学'.'，感谢您的关注';
                     echo "<xml>
                           <ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
                          <FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
                          <CreateTime>".time()."</CreateTime>
                          <MsgType><![CDATA[text]]></MsgType>
                          <Content><![CDATA[".$msg."]]></Content>
                          </xml>";
            }
            //普通的信息发送
            if($xml_arr['MsgType']=='text' && $xml_arr['Content'] == '111'){

                $media_id="您好 新的一天又要开始了 你努力了吗？";
                echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
                <FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
                <CreateTime>".time()."</CreateTime>
                <MsgType><![CDATA[voice]]></MsgType>
                <Content><![CDATA[".$media_id."]]></Content>
                </xml>";
              }

     }

}
