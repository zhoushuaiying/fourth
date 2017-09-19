<?php
namespace Weixin\Controller;
use Think\Controller;
class UserController extends CommonController {

	public  function get_userinfo()
	{
		
		$api = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->getToken()."&openid=".$this -> user_id."&lang=zh_CN";
		$res = getRequest($api);

		

		if(!$res['errcode'])
		{
			$str_info = '昵称:'.$res['nickname']."\n";
			$sex = $res['sex']==1?'男':'女';
			$str_info .= '性别:'.$sex."\n";

		}
		else
		{
			$str_info = $res['errmsg'];
		}

		return $str_info;
	}
}