<?php
namespace Weixin\Controller;
use Think\Controller;
class IndexController extends CommonController {
  
	public function _initialize()
	{
		$this -> message = A("Message");
	   	$this -> event   = A("Event");
	   	$this -> menu    = A("Menu"); 
	   	$this -> api     = A("Api");
   		$this -> user     = A("User");
   		$this -> oauth   = A("Oauth");
   		$this -> jssdk   = A("Jssdk");
	}

  public function index(){
       
	   
	   if(I('echostr'))
	   {   
		$this -> _access();
	   } 


	   

	   // $access_token = $this -> getToken();
	   // var_dump($access_token);
	   // $ip_list = $this -> getServerIp();
	   // var_dump($ip_list);

	   // $this -> menu -> createMenu();	
	   
	   $xml = file_get_contents("php://input");
	   save_Xml($xml);

/*$xml = "<xml><ToUserName><![CDATA[gh_d68ab2d21145]]></ToUserName>
<FromUserName><![CDATA[oCaFv09j72zQvPn6HUFXiiW7fSAc]]></FromUserName>
<CreateTime>1505812996</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[CLICK]]></Event>
<EventKey><![CDATA[userinfo]]></EventKey>
</xml>";*/
		if($xml == '')
		{
			exit;
		}
		
		$arr_xml = $this -> toArray($xml);
		$this->server_id = $arr_xml['ToUserName'];
		$this->user_id   = $arr_xml['FromUserName'];
		$this->msg_type  = $arr_xml['MsgType'];
		$this->arr_xml   = $arr_xml;
	
		//获取事件类型
		if($this->msg_type == "event")        //关注回复
		{	
			$this -> event_type = $arr_xml['Event'];
			// var_dump($this-> event_type);	
			$this -> event -> _events($this-> event_type);
		}
		elseif($this->msg_type == 'text')    //被动回复
		{
			$keyword = $arr_xml['Content'];	
			$this -> message -> _switchMsg($keyword);
			
		}	
		elseif($this->msg_type == 'image')  //回复图片消息
		{
			$pic_url = $arr_xml['PicUrl'];
			$media_id= $arr_xml['MediaId'];
			// $this -> message -> _imageMsg($media_id,'image');
			$arr_news = array(
				array('title' => '1',
					  'description' => '2',
					  'pic_url' => 'http://mmbiz.qpic.cn/mmbiz_jpg/rribZ3PwluQ0b9GB5Ixjia3aSLibPMpY6qibWsyGialZUoAq0F4yYWibDdmZrgYYrRwlts5FLx73T6IliaWLQicMTVjU2w/0',
					  'link'    => 'http://www.baidu.com'
			),
				array('title' => '2',
					  'description' => '3',
					  'pic_url' => 'http://mmbiz.qpic.cn/mmbiz_jpg/rribZ3PwluQ0b9GB5Ixjia3aSLibPMpY6qibWsyGialZUoAq0F4yYWibDdmZrgYYrRwlts5FLx73T6IliaWLQicMTVjU2w/0',
					  'link'    => 'http://www.baidu.com'
			),

			);
			$this -> message -> _response($arr_news,'news');
		}
  
    }
	
   //获取用户中心
    public function getUserinfo()
    {
    	
    	// $curr_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		$userinfo = $this -> oauth -> wxLogin();
		header("Content-type: text/html; charset=utf-8"); 
		echo "<a style='font-size:60px;color:red' href='".U('product')."'>产品中心</a>";	

    }

    //产品中心页面
    public function product()
    {
    	$userinfo = $this -> oauth -> wxLogin();
    	if(!$userinfo)
    	{
    		exit('授权失败');
    	}
        $data          = [];

        $timestamp = time();
        $nonceStr  = $this -> jssdk -> nonceStr(); 
        $signature = $this -> jssdk -> signature($nonceStr,$timestamp);
        $data['appid'] = C('APPID');
        $data['timestamp'] =  $timestamp;
        $data['nonceStr']  =  $nonceStr;
        $data['signature'] =  $signature;

        $this -> assign('data',$data);
    	$this -> display();
    }

    //获取微信服务器ip地址列表
    public function getServerIp()
    {
    	$server_ip = S('server_ip');
    	if(!$server_ip)
    	{
    		$api = "https://api.weixin.qq.com/cgi-bin/getcallbackip";
	    	$param = [
	    		"access_token" => $this -> getToken(),

	    	];
			$result = getRequest($api,$param);
			$ip_list = $result['ip_list'];
			S('server_ip',$ip_list);
    	}	
    	
    	return $server_ip;
    }


	public function upload()
	{
		  if(I('echostr'))
	   {   
		$this -> _access();
	   } 
		$this -> display();
	}

	//接入微信平台检验
	private function _access()
	{
		$singnature = I('signature');
		$timestamp  = I('timestamp');
		$nonce      = I('nonce');
		$echostr    = I('echostr');
		$token      = C('TOKEN');
		
		$array = array($token,$timestamp,$nonce);
		sort($array);
		$str   = implode($array); 
		$my_singnature = sha1($str);
		 if($singnature == $my_singnature)
		 {
			 echo $echostr;
		 }
		 else
		 {
			 echo '';
		 }	 
	}	
	

	

	 
}