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
   		$this -> user    = A("User");
   		$this -> oauth   = A("Oauth");
   		$this -> jssdk   = A("Jssdk");
	}

  public function index(){
       
		
	   if(I('echostr'))
	   {   
		$this -> _access();
	   } 

	   // $this -> api -> searchMenu();
	   // exit;
	   

	   // $access_token = $this -> getToken();
	   // var_dump($access_token);
	   // $ip_list = $this -> getServerIp();
	   // var_dump($ip_list);

	   // $this -> menu -> createMenu();	
	   
	   $xml = file_get_contents("php://input");
	   save_Xml($xml);

// $xml = "<xml><ToUserName><![CDATA[gh_d68ab2d21145]]></ToUserName>
// <FromUserName><![CDATA[oCaFv09j72zQvPn6HUFXiiW7fSAc]]></FromUserName>
// <CreateTime>1505980266</CreateTime>
// <MsgType><![CDATA[text]]></MsgType>
// <Content><![CDATA[多迪]]></Content>
// <MsgId>6468135991331503422</MsgId>
// </xml>";
		if($xml == '')
		{
			exit;
		}
		
		$arr_xml = $this -> toArray($xml);
		$this->server_id = $arr_xml['ToUserName'];
		$this->user_id   = $arr_xml['FromUserName'];
		$this->msg_type  = $arr_xml['MsgType'];
		$this->arr_xml   = $arr_xml;
	file_put_contents("ww.txt", $this->msg_type);
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

	public function get_upload()
	{

		$serverId = I("serverId");
		$access_token = $this -> getToken();
		$accessToken = $access_token;

		$media_id = $serverId;
		$path = './Public/Weixin/image/';
        if(!file_exists($path))
        {
            mkdir($path,0777,true);
            $path=rtrim($path,'/').'/';
        }
		$targetName = $path.date('YmdHis').mt_rand(0,999).'.jpg';


		$accessToken = $access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $fp = fopen($targetName,'wb');
        curl_setopt($ch,CURLOPT_URL,"http://file.api.weixin.qq.com/cgi-bin/media/get?access_token={$accessToken}&media_id={$serverId}");
        curl_setopt($ch,CURLOPT_FILE,$fp);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

		$img_url = "http://zhousy.5awo.com".ltrim($targetName,'.');
		$res = $this -> api ->  check_face($img_url);
		$data = ['code' => 0, 'info' => ''];
		if($res['code'] == 1)
		{
			$cutImage = cutImage($targetName,$res['info']);
			$data['code'] = 1;
			$data['info'] = "http://zhousy.5awo.com".ltrim($cutImage,'.');
			$this -> ajaxReturn($data);
		}
		else
		{
			$data['info'] = $res['info'];
			$this -> ajaxReturn($data);
		}



	}

	

    public function face()
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


	

	//接入微信平台检验
	private function _access()
	{
		$singnature = I('signature');
		$timestamp  = I('timestamp');
		$nonce      = I('nonce');
		$echostr    = I('echostr');
		$token      = C('TOKEN');
		$a = $singnature.'--'.$timestamp.'--'.$nonce.'--'.$echostr.'--'.$token;
	
		$array = array($token,$timestamp,$nonce);
		sort($array);
		$str   = implode($array); 
		$my_singnature = sha1($str);
		$b = $my_singnature;
	
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