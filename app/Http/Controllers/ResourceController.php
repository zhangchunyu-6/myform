<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use App\Model\Resource;
use Illuminate\Support\Facades\Storage;
class ResourceController extends Controller
{

    public $tools;
    public $request;
    public function _construct(Tools $tools,Request $request)
    {
        $this->tools=$tools;
        $this->request=$request;
    }
    //文件上传
    public function Resource()
    {
        return view('resource.html');
    }
    //文件下载
    public function download(Tools $tools,Request $request)
    {
        $req=$request->all();
        
        $url="https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=".$tools->get_access_token();
        $re =$tools->curl_post($url,json_encode(['media_id'=>$req['media_id']]));
        $result=\json_decode($re,1);
        
        $time=array(
            "http"=>array(
                'method'=>'GET',
                'timeout'=>'3'
            ),
            );

        $context=\stream_context_create($time);
         $file_resource = file_get_contents($result['down_url'],false,$context,$context);
        //dd($file_resource);
        Storage::put('/wechar/video/232311111.jpg', $file_resource);
      
    }
    //素材列表页
    public function resource_list(Tools $tools,Request $request)
    {
        //$model = new Resource;
      
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$tools->get_access_token();
       
        $data = [
            'type'=>'voice',
            'offset'=>'1',
            'count'=>'20'
        ];
        
        $re=$tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
       
        $result=json_decode($re,1);

        dd($result);
        
    }
    //文件上传
    public function upload_do(Tools $tools,Request $request)
    {
        $req=$request->all();
       // dd($req);
        $type_arr=['image'=>1,'voice'=>2,'video'=>3,'thumb'=>4];
        // if(!$request->hasFile($data)){
        //     dd('没有文件被上传');
        // }
        $file_obj=$request->file('resource');
        
        $file_ext=$file_obj->getClientOriginalExtension();
        //名称拼接
        $file_name =time().rand(1000,9999).'.'.$file_ext; 
        
        $path=$request->file('resource')->storeAs('wechar/'.$req['leixing'],$file_name);
         //新增其他类型永久素材
         $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$tools->get_access_token().'&type='.$req['leixing'];
        
        $data=[
            //存入路径
            'media'=>new \CURLFile(storage_path('app/public/'.$path)),
        ];
      
        
        if($req['leixing']=='video'){
            $data['description']=[
                'title'=>'标题',
                'introduction'=>'描述'
            ];
          $data['description']=json_encode($data['description'],JSON_UNESCAPED_UNICODE);
        }
       
        $re=$tools->wechar_curl_file($url,$data);   
        
        $result=json_decode($re,1);
        dd($result);
        
        if(!isset($result['errcode'])){
           
            Resource::insert([
                'media_id'=>$result['media_id'],
                'type'=>$type_arr[$req['leixing']],
                'path'=>'/storage/'.$path,
                'addtime'=>time()
                ]);
        }
        return "添加成功";
    }

    

    /**
     * 公众号调用或第三方平台帮公众号调用对公众号的所有api调用（包括第三方帮其调用）次数进行清零：
*/    
    public function clear_api(Tools $tools)
    {
        
        $url='https://api.weixin.qq.com/cgi-bin/clear_quota?access_token='.$tools->get_access_token();
        $data=['appid'=>env('WECHAR_APPID')];
        $re=$tools->curl_post($url,json_encode($data));
        $result=json_decode($re,1);
        dd($result);
    }
}
