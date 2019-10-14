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
		$key="mechar_access_token";
		if(Cache::has($key)){
			//取缓存
			//return "从缓存中获取信息";
			$wechar_access_token=Cache::get($key);
		}else{
			//取不到 调接口
			$res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WECHAR_APPID').'&secret='.env('WECHAR_SECRET'));
			$result=json_decode($res,1); 
			//dd($result);
			Cache::put($key,$result['access_token'],$result['expires_in']); 
			$wechar_access_token =$result['access_token'];
		}

		return $wechar_access_token;
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


}
