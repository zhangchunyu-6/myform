<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use DB;
class LoginController extends Controller
{
    public $tools;
    public $requers;
    public function __construct(Tools $tools,Request $request)
    {
        $this->tools=$tools;
        $this->requers=$request;
    }
    //登陆视图页面
       public function index()

    {
        return view('login.logindo');
    }



    public function wechar_login()
    {

        $redirect_uri=urlencode(env('APP_URL').'/wechar_code');
//        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAR_APPID').'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';        //            // dd($url);
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAR_APPID')."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header('location:'.$url);

    }

    /*
     获取code 然后用code换取token;

    */
    public function wechar_code(Request $request)
    {
        $req=$this->requers->all();
      //  dd($req);
        $url=file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAR_APPID').'&secret='.env('WECHAR_SECRET').'&code='.$req['code'].'&grant_type=authorization_code');
       // dd($url);
        $urls=json_decode($url,1);
        //dd($urls);
        $user=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$urls['access_token'].'&openid=OPENID&lang=zh_CN');
//        dd($user);
        $users=json_decode($user,1);
        $user_info=DB::table('user')->where(['openid'=>$users['openid']])->first();
      //  dd($user_info);
        if(!empty($user_info)){
//            存在存session
          //  dd(1111);
            $this->requers->session()->put('uid',$user_info->uid);
        }else{
//            不存在  存库中
            DB::beginTransaction(); //开启事务
            $uid= DB::table('user')->insertGetId([
                'name'=>$users['nickname'],
                'password'=>'125362',
                'u_time'=>time()
            ]);
            $insert_result=DB::table('user')->insert([
                'uid'=>$uid,
                'openid'=>$users['openid'],
            ]);
            if($uid && $insert_result){
                $this->requers->session()->put('uid',$user_info['uid']);
                DB::commit();
            }else{
                DB::rollback();
                dd('有误');
            }
        }
        $ur='https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_access_token().'&next_openid=';
        $use=$this->tools->curl_get($ur);
//        dd($use);
        $us=json_decode($use,1);
     //  dd($us['data']['openid'])
        //dd(已经登录);
        // return view('Login.user',['users'=>$us['data']['openid']]);
        return  redirect('/admin_create');
    }
}
