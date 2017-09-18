<?php
namespace Weixin\Controller;
use Think\Controller;
class EventController extends CommonController {

	private $message;

	public function _initialize()
	{

		parent::_initialize();
		$message = A('Message'); 
	}

//事件类型回复消息
	public function _events($event_type)
	{
		$message = A('Message'); 
		switch ($event_type) {
			//关注
			case 'subscribe':
				$event_key = $this -> arr_xml['EventKey'];
				$ticket    = $this ->arr_xml['Ticket'];
				if($event_key)
				{
					$contentStr = '欢迎关注我！你的场景值:'.$event_key;
				}
				else
				{
					$contentStr = "欢迎关注我!";
				}	
				$this ->$message -> _response($contentStr);
				break;
			//取消关注	
			case 'unsubscribe':
				
				break;
			//扫描	
			case 'SCAN':
				$event_key = $this ->arr_xml['EventKey'];
				$ticket    = $this ->arr_xml['Ticket'];
				$this ->$message -> _response('你的场景值:'.$event_key);
				break;
			default:
				$this ->$message -> _response('错误信息');
				break;
		}
		// if($event_type == "subscribe")
		// {
		// 	$contentStr = '欢迎关注我！';
		// }
		

	}


}
  
