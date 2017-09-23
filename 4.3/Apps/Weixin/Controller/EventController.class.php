<?php
namespace Weixin\Controller;
use Think\Controller;
class EventController extends CommonController {

	

//事件类型回复消息
	public function _events($event_type)
	{
		
		switch ($event_type) {
			//关注
			case 'subscribe':
				$event_key = $this -> arr_xml['EventKey'];
				$ticket    = $this -> arr_xml['Ticket'];
				if($event_key)
				{
					$contentStr = '欢迎关注我！你的场景值:'.$event_key;
				}
				else
				{
					$contentStr = "欢迎关注我!\n";
					
				}	
				$this -> message -> _response($contentStr);
				break;
			//取消关注	
			case 'unsubscribe':
				
				break;
			//扫描	
			case 'SCAN':
				$event_key = $this ->arr_xml['EventKey'];
				$ticket    = $this ->arr_xml['Ticket'];
				$this -> message -> _response('你的场景值:'.$event_key);
				break;
			case 'CLICK':
				$event_key = $this -> arr_xml['EventKey'];
				if($event_key == "海珠")
				{
					$this -> api -> searchWeather($event_key);

				}
				elseif($event_key == 'userinfo')
				{
					$userinfo = $this -> user -> get_userinfo();
					$this -> message -> _response($userinfo);
				}
				elseif($event_key == 'cai')
				{
					$this -> api -> searchMenu();

				}
				elseif ($event_key == 'code') {
					$this -> createTicket();
				}
				elseif($event_key == 'help')
					$contentStr = '';	
					$contentStr .= '1、输入 tq/城市名 可以查询天气'."\n";
					$contentStr .= '2、输入 cp/名字   可以查询菜谱'."\n";
					$contentStr .= '3、输入 new/频道   可以查询新闻频道,有一下频道可供查询：头条,新闻,财经,体育,娱乐,军事教育,科技,NBA,股票,星座,女性,健康,育儿'."\n";
					$contentStr .= '4、输入 news/名字  可以查询明星的具体新闻,例如 news/姚明'."\n";
					$contentStr .= '4、可以随时和图灵机器人聊天';
					$this -> message -> _response($contentStr);	
				break;	
			default:
				$this -> message -> _response('错误信息');
				break;
		}
	
		

	}


}
  
