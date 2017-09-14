<?php
	
	require_once "buildData.php";
	$arr = array(
		"city" => "海珠",
		"wendu" => 26,
		"yesterday" => array('data' => '1231','height' => 33)
	);
	
	$xml = response::xml('1','获取',$arr);
	echo $xml;
	