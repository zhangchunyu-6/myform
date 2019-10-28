<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use App\Model\Openid;
use App\Model\User;
class EventController extends Controller
{

    public function event(Tools $tools)
    {

        $info= file_get_contents("php://input");

        file_put_contents(storage_path('logs/wechar/'.date('Y-m-d').'.log'),"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);

        file_put_contents(storage_path('logs/wechar/'.date('Y-m-d').'.log'),$info,FILE_APPEND);

        $xml_obj = simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);

        $xml_arr =(array)$xml_obj;
       // dd($xml_arr);

               if($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'subscribe'){
                    //判断open表当前是否有openid

                    $openid_info= Openid::where(['openid'=>$xml_arr['FromUserName']])->first();

                    if(empty($openid_info)){
                        //首次关注

                        //dd(111);
                        if(isset($xml_arr['Ticket'])){
                            //带参数
                            $share_code= explode("_",$xml_arr['EventKey'])[1];

                            Openid::insert([
                                'uid'=>$share_code,
                                'openid'=>$xml_arr['FromUserName'],
                                'subscribe'=>1
                            ]);
                            User::where(['id'=>$share_code])->increment('share_num',1);//加业绩
                        }else{
                            //普通关注；
                            Openid::insert([
                                'uid'=>0,
                                'openid'=>$xml_arr['FromUserName'],
                                'subscribe'=>1
                            ]);
                        }
                    }

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
                        <CreateTime>".time()."</CreateTime>h44-h
                        <MsgType><![CDATA[text]]></MsgType>
                        <Content><![CDATA[".$media_id."]]></Content>
                        </xml>";
                      }
     }

}
