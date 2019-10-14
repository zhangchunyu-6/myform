<?php

namespace App\Http\Controllers;
use App\Tools\Tools;
use Illuminate\Http\Request;

class TagController extends Controller
{


    public function Tag_list(Tools $tools)
    {
   
        $result=$tools->tag_list();
        //将获取到的值发送给列表页 循环出来
       return view('Tag.tag_list',['data'=>$result['tags']]);
    }


    public function Tag_add(Request $request, Tools $tools)
    {
        //判断添加
        if($request->isMethod('POST')){
            //接收传过来的值
            $req=$request->all();
            //调用微信添加接口
            $url=('https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$tools->get_access_token());
                
                $data= [
                            'tag'=>[
                                'name'=>$req['tag_name']
                             ]
                       ];
            //POST请求
            $re = $tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
            
            $request=json_decode($re);
             
        }
        return view('Tag.tag_add');
    }

    //标签的删除
    public function Tag_del(Tools $tools,Request $request)
    {
            //接收id
            $req=$request->all();    
            //调用微信接口
            $url=('https://api.weixin.qq.com/cgi-bin/tags/delete?access_token='.$tools->get_access_token());
                $data = [
                    'tag'=>[
                        'id'=>$req['tag_id']
                    ]
                ];
            $re =$tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
            $result = \json_encode($re,true);
            dd($result);
    }

    public function Tag_edit(Tools $tools,Request $request)
    {
         //接收用户id
         $req =$request->all();
         //dd($req);
        return view('Tag.tag_edit',['tag_id'=>$req['tag_id'],'tag_name'=>$req['tag_name']]);
    }

    public function tag_update(Request $request,Tools $tools)
    {
        //.<标签的修改>
        //1.接收要修改的值
         $req= $request->all();
        //2.调用接口
         $url=('https://api.weixin.qq.com/cgi-bin/tags/update?access_token='.$tools->get_access_token());
           
             $data=[
                'tag'=>[
                    'id'=>$req['tag_id'],
                    'name'=>$req['tag_name']
                       ]
                  ];

            $re=$tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
                  $result=\json_decode($re,true);
                  dd($result);
            
            //dd($re);

    }


    public function tag_user_add(Request $request,Tools $tools)
    {
        //1.接收传过来的值
        $req = $request->all();
       // dd($req);
        //2.调用微信给用户打标签的接口
        $url=('https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$tools->get_access_token());
        //3.转换为数组
            $data=[
                'tagid'=>$req['tag_id'],
                'openid_list'=>$req['openid_list']

             ];
             //4.请求post方法
            $re=$tools->curl_post($url,\json_encode($data,JSON_UNESCAPED_UNICODE));
            //5.将他转为一个json串格式
            $result=\json_decode($re);
            dd($result);
    }


    /* 用户已有的标签 */
    public function tag_sou(Tools $tools,Request $request)
    {
        $req =$request->all();
        $url=('https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token='.$tools->get_access_token());
            $data=[
                'openid'=>$req['openid']
            ];
            $re=$tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
            $result=json_decode($re,true);
           // dd($result);
            $tag_list=$tools->tag_list()['tags'];
           // dd($tag_list);
             foreach($result['tagid_list'] as $v){
                    foreach($tag_list as $vo){
                        if($v==$vo['id']){
                            echo $vo['name']."<br>";
                        }
                    }
              }

              /// return view('wechar.tag_user_list',['list'=>$request['tagid_list']]);
            
    }
    
}
