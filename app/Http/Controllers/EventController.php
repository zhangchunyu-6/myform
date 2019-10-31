<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use App\Model\Openid;
use App\Model\User;
use App\Model\Userwechar;
class EventController extends Controller
{

    public function event(Tools $tools)
    {

        $info= file_get_contents("php://input");

        file_put_contents(storage_path('logs/wechar/'.date('Y-m-d').'.log'),"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);

        file_put_contents(storage_path('logs/wechar/'.date('Y-m-d').'.log'),$info,FILE_APPEND);

        $xml_obj = simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);

        $xml_arr =(array)$xml_obj;
       //dd($xml_arr);

               if($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'subscribe'){
                    //判断open表当前是否有openid

                    $openid_info= Openid::where(['openid'=>$xml_arr['FromUserName']])->first();
                    //dd($openid_info);
                    if(empty($openid_info)){
                        //首次关注

                        if(isset($xml_arr['Ticket'])){
                            //带参数
                          //  dd(111);
                            $share_code= explode("_",$xml_arr['EventKey'])[1];
                            //dd($share_code);
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
                   $msg = '您好'.$wechar_user['nickname'].'帅哥'.'，欢迎您关注天气预告公众号
                        发送1 查看本班讲师姓名
                        发送2 查看本班讲师帅照';
                         echo "<xml>
                               <ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
                              <FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
                              <CreateTime>".time()."</CreateTime>
                              <MsgType><![CDATA[text]]></MsgType>
                              <Content><![CDATA[".$msg."]]></Content>
                              </xml>";
                      }

                    //普通的信息发送
                    if($xml_arr['MsgType']=='text' && $xml_arr['Content'] == '1'){
                        $media_id="本班这个月的讲师是白伟";
                        echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
                        <FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
                        <CreateTime>".time()."</CreateTime>
                        <MsgType><![CDATA[text]]></MsgType>
                        <Content><![CDATA[".$media_id."]]></Content>
                        </xml>";
                      }

                    if($xml_arr['MsgType'] == 'text' && $xml_arr['Content'] == '2'){
                        $media_id="c0Sti5vGtc4zkKbE7HjoSRnyZT57BrM1R68nhudydWA";
                        echo "<xml>
                      <ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName>
                      <FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName>
                      <CreateTime>".time()."</CreateTime>
                      <MsgType><![CDATA[image]]></MsgType>
                      <Image>
                      <MediaId><![CDATA[".$media_id."]]></MediaId>
                      </Image>
                      </xml>";
                    }

     }

}
