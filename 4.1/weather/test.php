<?php    
	
	require('../function/cityKey.php');
	require('../function/httpClient.php');
	
	// header("Content-type:text/xml");
	$city_url = "http://wthrcdn.etouch.cn/WeatherApi?citykey=101010100";
	
	$str = httpClient::getRequest($city_url,array(),'string');
	$obj = simplexml_load_string($str);
	$arr = json_decode(json_encode($obj) , true);
	var_dump($arr);

?>	