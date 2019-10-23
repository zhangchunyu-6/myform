<?php

namespace App\Http\Controllers;
use App\Tools\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\User;
class ListController extends Controller
{
    public function wecharindex()
    {
            $user_model= new User;

            $data=$user_model::get();
            //dd($data);
            return  view('wechar.wechar_list',['list'=>$data]);
    }

    public function save_code(Request $request,Tools $tools)
    {
            $req=$request->all();
           // dd($req);
            $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$tools->get_access_token();
           // dd($url);
        //POST数据例子：{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}
            $data=[
                    "expire_seconds"=> 30 * 24 * 3600,
                    "action_name"=>'QR_SCENE',
                    'action_info'=>[
                        'scene'=>[
                            'scene_id'=>$req['uid']
                        ],
                    ]
            ];

            $re=$tools->curl_post($url,json_encode($data));
            $result=json_decode($re,1);
            //dd($result);
            //通过ticket换取二维码
            $qrcode_url="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$result['ticket'];
            //发送get请求
            $qrcode_source=$tools->curl_get($qrcode_url);
            //dd($qrcode_source);
            $qrcode_name=$req['uid'].rand(10000,99999).'.jpg';
            //dd($qrcode_name);
            Storage::put('wechar/qrcode/'.$qrcode_name,$qrcode_source);
            User::where(['id'=>$req['uid']])->update([
                'qrcode_url'=>'/storage/wechar/qrcode/'.$qrcode_name
            ]);
           return  redirect('/wechar/list');

    }
}
