<?php
	require('../function/cityKey.php');
	require('../function/httpClient.php');
	
	$ip_url = "http://ip.taobao.com/service/getIpInfo.php";
	
	error_reporting(E_ALL & ~E_NOTICE);
		
		
	if(isset( $_GET['ip']))
	{
		$ip = $_GET['ip'];
		$a = httpClient::getRequest($ip_url,array('ip' => $ip));
		// var_dump($a['data']['forecast']);exit;
		if($a['code'] == 0)
		{
			var_dump($a['data']);exit;
		}
				
		
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>查询ip</title>
</head>


<body>
	<form>
		<input type="text" name="ip">
		<button type="submit">查询</button>

	</form>
</body>

</html>