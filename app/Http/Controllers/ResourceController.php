<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class ResourceController extends Controller
{
    //文件上传
    public function Resource()
    {
        return view('resource.html');
    }

    public function upload_do(Tools $tools,Request $request)
    {
        $data=$request->all();
      
        // if(!$request->hasFile($data)){
        //     dd('没有文件被上传');
        // }
        $file_obj=$request->file('resource');
        // dd($file_obj);
        $file_ext=$file_obj->getClientOriginalExtension();
        // dd($file_ext);
        $file_name =time().rand(1000,9999).'.'.$file_ext; 

        $path=$request->file('resource')->storeAs('wechar/'.$data['leixing'],$file_name);
         //dd($path);
        $url ="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$tools->get_access_token()."&type=".$data['leixing'];
      //dd($url);
        $re=$tools->wechar_curl_file($url,storage_path('app/public/'.$path));
     
   
        $result=json_decode($re,1);
        dd($result);
    }
}
