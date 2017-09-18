<?php
namespace Weixin\Controller;
use Think\Controller;
class IndexController extends Controller {
  
	public $server_id;
	public $user_id;
	public $msg_type;

  public function index(){
       
	   
	   if(I('echostr'))
	   {   
		$this -> _access();
	   } 
	   
	   // $access_token = $this -> getToken();
	   // var_dump($access_token);
	   // $ip_list = $this -> getServerIp();
	   // var_dump($ip_list);

	   
	   $xml = file_get_contents("php://input");
	   save_Xml($xml);

		if($xml == '')
		{
			exit;
		}
		
		$arr_xml = $this -> _array($xml);
		$this->server_id = $arr_xml['ToUserName'];
		$this->user_id   = $arr_xml['FromUserName'];
		$this->msg_type  = $arr_xml['MsgType'];
			
		//获取事件类型
		if($this->msg_type == "event")        //关注回复
		{	
			$event_type = $arr_xml['Event'];
			$this -> _events($event_type);
		}
		elseif($this->msg_type == 'text')    //被动回复
		{
			$keyword = $arr_xml['Content'];	
			$this -> _switchMsg($keyword);
			
		}	
		elseif($this->msg_type == 'image')  //回复图片消息
		{
			$pic_url = $arr_xml['PicUrl'];
			$media_id= $arr_xml['MediaId'];
			// $this -> _imageMsg($media_id);
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
			$this -> _response($arr_news,'news');
		}
  
    }
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
    //获取微信服务器ip地址列表
    public function getServerIp()
    {
    	$api = "https://api.weixin.qq.com/cgi-bin/getcallbackip";
    	$param = [
    		"access_token" => $this -> getToken(),

    	];
		$result = getRequest($api,$param);
		$ip_list = $result['ip_list'];

		return $ip_list;

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
	

	// 转化为数组
	public function _array($xml)
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
	//更具文本内容回复消息
	public function _response($msg,$type='text') 
	{
		switch ($type) {
			case 'text':
				
				$this -> _reply_text($msg);
				break;

			case 'image':
				
				$this -> _reply_image($msg);
				break;
			case 'news':
				
				$this -> _reply_news($msg);
				break;

			default: 
				# code...
				break;
		}
	}
	//文本消息回复
	public function _reply_text($msg)
	{
		$str_replay= "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%d</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content></xml>";
		$time      = time();
		$str_replay=sprintf($str_replay,$this->user_id,$this->server_id,$time,$msg);
		echo $str_replay;
	}
	//图片消息回复
	public function _reply_image($msg)
	{
		$str_replay="<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%d</CreateTime>
					<MsgType><![CDATA[image]]></MsgType>
					<Image>
					<MediaId><![CDATA[%s]]></MediaId>
					</Image>
					</xml>"; 
		$time      = time();
		$str_replay=sprintf($str_replay,$this->user_id,$this->server_id,$time,$msg);
		echo $str_replay;
	}
	//图文消息回复
	public function _reply_news($arr)
	{
		if(is_array($arr))
		{
			$str_replay="<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%d</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>".count($arr)."</ArticleCount><Articles>";

			foreach ($arr as $key => $value) {
			$str_replay .= "<item><Title><![CDATA[".$value['title']."]]></Title> 
				<Description><![CDATA[".$value['description']."]]></Description>
				<PicUrl><![CDATA[".$value['pic_url']."]]></PicUrl>
				<Url><![CDATA[".$value['link']."]]></Url></item>";
			}
					
					
				$str_replay .= "</Articles></xml>"; 
				$time      = time();
				$str_replay=sprintf($str_replay,$this->user_id,$this->server_id,$time);
				echo $str_replay;
		}
		else
		{
			echo '';
		}	
		
	}

	//时间类型回复消息
	public function _events($event_type)
	{

		switch ($event_type) {
			//关注
			case 'subscribe':
				$event_key = $arr_xml['EventKey'];
				$ticket    = $arr_xml['Ticket'];
				if($event_key)
				{
					$contentStr = '欢迎关注我！你的场景值:'.$event_key;
				}
				else
				{
					$contentStr = "欢迎关注我!";
				}	
				$this -> _response($contentStr);
				break;
			//取消关注	
			case 'unsubscribe':
				
				break;
			//扫描	
			case 'SCAN':
				$event_key = $arr_xml['EventKey'];
				$ticket    = $arr_xml['Ticket'];
				$this -> _response('你的场景值:'.$event_key);
				break;
			default:
				$this -> _response('错误信息');
				break;
		}
		// if($event_type == "subscribe")
		// {
		// 	$contentStr = '欢迎关注我！';
		// }
		

	}

	//筛选内容 回复消息
	public function _switchMsg($keyword)
	{
		if(!empty( $keyword ))
        {
      		
			if($keyword == '1')
			{
				$contentStr = '微信';
			}
			else if($keyword == '2')
			{
				$contentStr = '小程序';		
			}	
			else
			{
        		$contentStr = "Welcome to wechat world!";
			}
        	
        }else{
        		$contentStr = "Input something...";
        }

        $this -> _response($contentStr);

	}

	//图片回复
	public function _imageMsg($media_id)
	{
		$this -> _response($media_id,'image');
	}

	 public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		
      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
				
               $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";        			
				if(!empty( $keyword ))
                {
              		$msgType = "text";
					if($keyword == '1')
					{
						$contentStr = '微信';
					}
					else if($keyword == '2')
					{
						$contentStr = '小程序';		
					}	
					else
					{
                	$contentStr = "Welcome to wechat world!";
					}
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
}