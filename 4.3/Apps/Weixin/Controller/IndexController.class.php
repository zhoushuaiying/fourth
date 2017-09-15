<?php
namespace Weixin\Controller;
use Think\Controller;
class IndexController extends Controller {
  
  public function index(){
       
	   
	   if(I('echostr'))
	   {   
		$this -> _access();
	   } 
	   
	   $xml = file_get_contents("php://input");
	   save_Xml($xml);
	   
	   $this -> responseMsg();
	   
	  
	   
    }
	
	
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