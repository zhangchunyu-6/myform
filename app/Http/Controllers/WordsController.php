<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class WordsController extends Controller
{
    //留言粉丝页面
    public function words(Tools $tools)
    {
        $openid_list=$tools->fans();
        //dd($openid_list);
        return view('words.words_list',['list'=>$openid_list]);
    }

    //发送列表页
    public function word_code(Request $request,Tools $tools)
    {
         $req=$request->all();
        // //dd($req);
        // $url="https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=".$tools->get_access_token();
        //     $data=[
        //         "template_id_short"=>"TM00015"
        //     ];
        // $re=$tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        // dd($re);
        return view('words.word_code',['openid'=>$req['openid']]);
    }

    //群发执行页面;
    public function word_do(Request $request,Tools $tools)
    {
        $req=$request->all();
        //dd($req['content']);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tools->get_access_token();
      
        $Info=[
            'touser'=>$req['openid'],
            "template_id"=>"UvsdWDZlSKplDLhGDgwwdT4ynlhs6tyxJEibsNhNFzw",
            "data"=>[
                "first"=>[
                    "value"=>$req['content'],
                ]
            ]
        ];
        $re=$tools->curl_post($url,\json_encode($Info,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,true);
        echo  "<script>alert('发送成功')</script>";
    }
       
}
