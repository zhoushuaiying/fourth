<?php
namespace Weixin\Controller;
use Think\Controller;
class MessageController extends CommonController{

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
}