<?php
namespace App\Tools;
use Illuminate\Support\Facades\Cache;

class Tools
{
    public function char()
	{
	  $access_token = $this->get_access_token();
	  echo $access_token;
	}



	public function get_access_token()
	{
			$key='wechat_access_token';
     //dd($key);
    //判断是否为空
			if(Cache::has($key)){
		// 有，取出来
		$wechat_assess_token=Cache::get($key);
		}else{
		// 没有，从微信获取
		$file=file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WECHAR_APPID').'&secret='.env('WECHAR_SECRET'));
		$re=json_decode($file,1);
		// 存
		Cache::put($key,$re['access_token'],$re['expires_in']);
		$wechat_assess_token=$re['access_token'];
	  }
		return $wechat_assess_token;
	}

	public function wechar_curl_file($url,$data)
    {
        $curl=curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);

        curl_setopt($curl,CURLOPT_POST,true);

        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);

        $result=curl_exec($curl);
        curl_close($curl);
        return $result;
    }


	public function curl_post($url,$data)

	{

			$curl = curl_init($url);

			curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);

			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);

			curl_setopt($curl,CURLOPT_POST,true);

			curl_setopt($curl,CURLOPT_POSTFIELDS,$data);

			$result = curl_exec($curl);

			curl_close($curl);

			return $result;

	}


	public function curl_get($url)

	{

			$curl = curl_init($url);

			curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);

			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);

			$result = curl_exec($curl);

			curl_close($curl);

			return $result;

	}

	 public function tag_list()
	 {
		      //请求微信 获取用户列表页面
					$url=('https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->get_access_token());

					//调用GET方法
					$re=$this->curl_get($url);
					//将获取到的值转为json串
					$result=json_decode($re,true);
					return $result;
	 }

	 public function get_wechar_user($openid)

    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->get_access_token().'&openid='.$openid.'&lang=zh_CN';
        $re = file_get_contents($url);
        $result = json_decode($re,1);
        return $result;
		}

		public function sortInfo($data,$parent_id=0)
		{
			$info=[];
			foreach($data as $v){
				if($v['parent_id']==$parent_id){
					$son=sortInfo($data,$v['sort_id']);
					$v['son']=$son;
					$info[]=$v;
				}
			}
			return $info;
		}


		public function fans()
		{
			$token=$this->get_access_token();
			//dd($token);
			//        获取openid
        $openid=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$token.'&next_openid=');
				//dd($openid);
				$re=json_decode($openid,1);
       //dd($re);
        $openid_list=[];
        foreach ($re['data']['openid'] as $v)
        {
//            获取用户基本信息
            $user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->get_access_token().'&openid='.$v.'&lang=zh_CN');
            $res=json_decode($user_info,1);
     // dd($res);
            $openid_list[]=$res;
				}
				return $openid_list;
		}


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
        $ur='https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->get_access_token().'&next_openid=';
        $use=$this->curl_get($ur);
//        dd($use);
        $us=json_decode($use,1);
        //  dd($us['data']['openid'])
        //dd(已经登录);
         //return view('admin.create',['users'=>$us['data']['openid']]);

    }


}
