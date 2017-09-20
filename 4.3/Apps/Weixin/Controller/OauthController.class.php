<?php
namespace Weixin\Controller;
use Think\Controller;
class OauthController extends CommonController {
	//引导授权
	public function wxLogin()
	{
		$userinfo = session('userinfo');
		// $userinfo = session('userinfo',null);
		// exit;
		if(!$userinfo)
		{
			$userinfo = $this  -> _goOauth(); //授权 
		}

		return $userinfo;
	}

	private function _goOauth($scope="snsapi_userinfo")
	{
		$code = I('get.code');

		if(!$code)
		{
			$redirect_uri = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$redirect_uri = urlencode($redirect_uri); 
		    $api = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".C('APPID')."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=zhou#wechat_redirect"; 
		    redirect($api);
		    
		    echo "<script>location.reload()</script>";
		  
		}
		//第二步：通过code换取网页授权access_token
		else
		{
			$state = I('get.state');
			if($state != 'zhou')
			{
				exit('验证失败');
			}
			else
			{
				$access_token = $this -> _getOauthAccessToken($code);
				if($res['errcode'])
				{
					exit($res['errmsg']);
				}
				// 第四步：拉取用户信息(需scope为 snsapi_userinfo)
				else
				{
					$userinfo = $this -> _getUserinfo($access_token);
						
				}
			}
			return $userinfo;
		}

		

	    //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf0e81c3bee622d60&redirect_uri=http%3A%2F%2Fnba.bluewebgame.com%2Foauth_response.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect  
		//回调地址

	} 


	private function _getOauthAccessToken($code)
	{
		$api = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".C('APPID')."&secret=".C('APPSECRET')."&code=".$code."&grant_type=authorization_code";

		$res = getRequest($api);
		return $res;
	}
	private  function _getUserinfo($res)
	{
		$api = "https://api.weixin.qq.com/sns/userinfo?access_token=".$res['access_token']."&openid=".$res['openid']."&lang=zh_CN ";
		$userinfo = getRequest($api);
		if($userinfo['errcode'])
		{
			exit($userinfo['errmsg']);
		}
		else
		{
			//保存用户信息
			session('userinfo',$userinfo);
		}	
	}

}