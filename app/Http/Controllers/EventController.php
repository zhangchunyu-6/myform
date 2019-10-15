<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class EventController extends Controller
{
    public function event(Tools $tools)
    {
      
        $info= file_get_contents("php://input");
        //将格式 隔开
        file_put_contents(storage_path('logs/wechar/'.date('Y-m-d').'.log'),"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
        //加载一个log日志 每天写入一次 
        file_put_contents(storage_path('logs/wechar/'.date('Y-m-d').'.log'),$info,FILE_APPEND);
      //将$info数据转换为xml                 //SimpleXMLElement格式对象 将 CDATA 设置为文本节点
        $xml_obj = simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);
        //然后在强制转换为数组格式
        $xml_arr = (array)$xml_obj;

        dd($xml_arr);
    }                                                                                                                                    
}
