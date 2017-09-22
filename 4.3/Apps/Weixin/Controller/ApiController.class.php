<?php
namespace Weixin\Controller;
use Think\Controller;
class ApiController extends CommonController {
	//查询天气
	public function searchWeather($city)
	{

  		$city_url = "http://wthrcdn.etouch.cn/weather_mini";
		$a = getRequest($city_url,array('city' => $city));
		$weather_msg = '';
		if($a['status'] == 1000)
		{
			$data = $a['data'];
			$city_name = $data['city'];
			$ganmao    = $data['ganmao'];
			$wendu     = $data['wendu'];

			$weather_msg .= '城市:'.$city_name."\n";
			$weather_msg .= '感冒指数:'.$ganmao."\n";
			$weather_msg .= '温度:'.$wendu."\n";

			$contentStr = $weather_msg;

		}
		else 
		{
			$contentStr = '无效的城市名称';
		}

		$this -> message ->  _response($contentStr."\n\n回复 tq/城市名 可以查询其它城市");
	

	}

	//查询菜谱
	public function searchMenu($keyword="白菜")
	{
		$menu_url = "https://way.jd.com/jisuapi/search";
		$url = "https://way.jd.com/jisuapi/search?keyword=".$keyword."&num=10&appkey=911b61c975768fe4d8a7a4c6ec566958";
		
		$res = file_get_contents($url);
		$res = json_decode($res,true);
		// var_dump($res);exit;
		if((!empty($res)) && $res['code'] == 10000 )
		{
			
			if($res['result']['result']!='')
			{
				$data = $res['result'];
				$coul = '';
				$i = 0;
				foreach ($data['result']['list'] as $key => $value) {

					$coul = implode(",", array_column($value['process'], 'pcontent')) ;
					if($i<4)
					{

						$list[] = "第".(++$key)."种:\n\t\t".$coul."\n";
					}	
					$i++;
				}

				$result = implode($list);
				
			}
			else
			{
				$result = '输入的搜索菜单无效';
			}

		}
		else
		{
			$result = '找不到';
		}
		
		$this -> message -> _response($result);
		
		
	}

	//人脸检测
	public function  check_face($img_url="http://zhousy.5awo.com/Public/Weixin/image/20170922143449888.jpg")
	{
		$api_url1 = "https://way.jd.com/hnadata/faceDetect?Timestamp=".date('Y-m-d H:i:s')."&imageUrl=".$img_url."&appkey=911b61c975768fe4d8a7a4c6ec566958";
		$api_url = "https://way.jd.com/hnadata/faceDetect";
		$param = [
			'Timestamp' => date('Y-m-d H:i:s'),
			'imageUrl' => $img_url,
			'appkey'   => '911b61c975768fe4d8a7a4c6ec566958',
		];
		// $res = file_get_contents($api_url);
		$res = getRequest($api_url,$param);
		// $res = json_decode($res,true);
		$data = ['code' => 0,'info' => ''];
		if((!empty($res)) && $res['code'] == 10000 )
		{
			$list = $res['result']['msgResponse']['data']['faces'];
			if($list!='')
			{
				$data['code'] = 1;
				$data['info'] = $list[0]['face_rectangle'];

			}
			else
			{
				$data['info'] = '图片无效';

			}
		}
		else
		{
			$data['info'] = '图片无效';

		}
		// var_dump($data);		
		return $data;
	}

	//聊天机器人
	public function tuling($key='天气')
	{
		$api = "https://way.jd.com/turing/turing";
		$param = [
			'info'   => $key,
			'loc'    => '广州市',
			'userid' => 222, 
			'appkey' => "911b61c975768fe4d8a7a4c6ec566958",
		];

		$res = getRequest($api,$param);
		// $data = ['code' => 0,'info' => ''];
		file_put_contents("tuling.txt", json_encode($res));

		if((!empty($res)) && $res['code'] == 10000 )
		{
			$data = $res['result'];
			if(!empty($data))
			{
				if($data['code'] == 100000)
				{
					$info =$data['text'];
				}
				else
				{
					$info  = $data['text'];
					$info .= "\n";
					$info .= $data['url']; 
				}


			}	
		}
		else
		{
			$info = '我真的不知道你说什么';
		}

		return $info;

	}
	 
}