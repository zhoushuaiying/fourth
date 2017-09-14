<?php


	require('../function/cityKey.php');
	require('../function/httpClient.php');
	
	$city_url = "http://wthrcdn.etouch.cn/weather_mini";
	
	error_reporting(E_ALL & ~E_NOTICE);
		
		
	if(isset( $_GET['city']))
	{
		$city = $_GET['city'];
		$a = httpClient::getRequest($city_url,array('city' => $city));
		// var_dump($a['data']['forecast']);exit;
		if($a['status'] == 1000)
		{
			$data = $a['data'];
			$yesterday = $data['yesterday'];
			$forecast  = $data['forecast'];
			$city_name      = $data['city'];
			$ganmao    = $data['ganmao'];
			$wendu     = $data['wendu'];	
		}
				
		
	}
	

	
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>查询天气</title>
</head>

<body>
	<form>
		<input type="text" name="city">
		<button type="submit">查询</button>
	</form>
	
	<div id="show">
		<?php if($a['status'] == 1000):?>
			<?='城市:&nbsp;'.$city_name;?><br/>
			
			<?='感冒程度:&nbsp;'.$ganmao;?><br/>
			<?='温度:&nbsp;'.$wendu;?><br/>
			<hr/>
			
			<?='昨天天气情况:&nbsp;'?><br/>
			<?='日期:&nbsp;'.$yesterday['date'];?><br/>
			<?='最高温:&nbsp;'.$yesterday['high'];?><br/>
			<?='风向:&nbsp;'.$yesterday['fx'];?><br/>
			<?='最低温:&nbsp;'.$yesterday['low'];?><br/>
			<?='风力:&nbsp;'.$yesterday['fl'];?><br/>
			
			<hr/>
			<?='未来5天:&nbsp;';?><br/>
			
			<?php foreach($forecast as $key => $v):?>
			
				<?='日期:&nbsp;'.$v['date'];?><br/>
				<?='最高温:&nbsp;'.$v['high'];?><br/>
				<?='风向:&nbsp;'.$v['fengxiang'];?><br/>
				<?='最低温:&nbsp;'.$v['low'];?><br/>
				<?='情况:&nbsp;'.$v['type'];?><br/>
				<br/>
				<br/>
				
			<?php endforeach;?>
		<?php endif;?>
	</div>
</body>
</html>