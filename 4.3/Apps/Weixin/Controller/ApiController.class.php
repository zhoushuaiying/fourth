<?php
namespace Weixin\Controller;
use Think\Controller;
class ApiController extends CommonController {

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

		$this -> message-> _response($contentStr);

	}
}