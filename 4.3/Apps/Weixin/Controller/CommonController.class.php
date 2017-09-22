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
		

		$result = $this->_request('get',$get_url);
		$file = "code.jpg";
        if($file){
            file_put_contents($file,$result);
        }else{
            header('Content-Type:image/jpeg');
            echo $result;
        }  
	}

	
private function _request($method='get',$url,$data=array(),$ssl=true){
          //curl完成，先开启curl模块
          //初始化一个curl资源
          $curl = curl_init();
          //设置curl选项
          curl_setopt($curl,CURLOPT_URL,$url);//url
          //请求的代理信息
          $user_agent = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
          curl_setopt($curl,CURLOPT_USERAGENT,$user_agent);
         //referer头，请求来源        
         curl_setopt($curl,CURLOPT_AUTOREFERER,true);
         curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间
         //SSL相关
         if($ssl){
             //禁用后，curl将终止从服务端进行验证;
             curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
             //检查服务器SSL证书是否存在一个公用名
             curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
         }
         //判断请求方式post还是get
         if(strtolower($method)=='post') {
             /**************处理post相关选项******************/
             //是否为post请求 ,处理请求数据
            curl_setopt($curl,CURLOPT_POST,true);
             curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
         }
         //是否处理响应头
         curl_setopt($curl,CURLOPT_HEADER,false);
         //是否返回响应结果
         curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
         
         //发出请求
         $response = curl_exec($curl);
         if (false === $response) {
             echo '<br>', curl_error($curl), '<br>';
             return false;
         }
         //关闭curl
        curl_close($curl);
         return $response;
    }

}