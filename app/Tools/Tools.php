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
	
	public function wechar_curl_file($url,$path)
    {
        $curl=curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);

        curl_setopt($curl,CURLOPT_POST,true);
        $data=[
            'media'=>new \CURLFile(realpath($path)),
        ];
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


}
