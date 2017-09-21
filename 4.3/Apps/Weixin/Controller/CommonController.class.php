<?php
namespace Weixin\Controller;
use Think\Controller;
class CommonController extends Controller {

	public static $server_id;
	public static $user_id;
	public static $msg_type;
	public static $arr_xml;
	public static $event_type;
	public static $message;
	public static $event; 
	public static $menu;
	public static $api;
	public static $user;
	public static $oauth;
	public static $jssdk;
	//获取access_token
    public function getToken()
    {
		$access_token = S('access_token');  //缓存中取 access_token

		if(!$access_token) //微信接口获取access_token
		{
			$api   = "https://api.weixin.qq.com/cgi-bin/token";
	    	$param = [
	    		"grant_type" => "client_credential",
	    		"appid"	     => C('APPID'),
	    		"secret"     => C('APPSECRET'),
	    	];

    		$result = getRequest($api,$param);	
    		$access_token = $result['access_token'];
    		S('access_token',$access_token);
		}
		return $access_token;
    }


    // 转化为数组
	public function toArray($xml)
	{
		$obj_xml = simplexml_load_string($xml);
		$arr_xml = (array)$obj_xml;
		foreach ($arr_xml as $key => $value) {
			if(is_object($value))
			{
				$arr_xml[$key] = (string)$value; 	
			}
		}

		return $arr_xml;
	}


	//生成带场景值的微信二维码图片
	public function createTicket(){
		$access_token = $this->getToken();
		$api = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;

		$scene_id = I('scene_id','123');	//取得要生成的场景值
		//{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
		$arr_post = array(
			'action_name'=>'QR_LIMIT_SCENE',
			'action_info'=>array('scene'=>array('scene_id'=>$scene_id))
			);
		$str_post = json_encode($arr_post);
		$arr_return = postRequest($api,$str_post);
		$ticket = $arr_return['ticket'];
		$get_url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
		
		// header("content-type:image/jpeg");
		// header('Content-type:image.jpeg'); 
		// echo file_get_contents($get_url);
		// $result = getRequest($get_url);
		// echo $result;
		echo "<img src='".$get_url."'>";
	}
}