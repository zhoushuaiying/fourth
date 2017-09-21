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

		$this -> message ->  _response($contentStr."\n\n回复 tq/城市名 可以查询其它城市");
		$this -> message ->  _response();

	}


	public function searchMenu($keyword="白菜")
	{
		$menu_url = "https://way.jd.com/jisuapi/search";
		$arr = array('keyword' => $keyword,
				     'num'    => 10,
				     'appkey' => "911b61c975768fe4d8a7a4c6ec566958"
					);
		$res = getRequest($menu_url,$arr);
		$res = json_decode($res);
		$contentStr = $res;

		$this -> message -> _response($contentStr);
	}
}