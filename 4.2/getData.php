<?php
	require_once "buildData.php";
	$arr = array(
		"city" => "海珠",
		"wendu" => 26,
		"yesterday" => array('data' => '1231','height' => 33)
	);
	
	$data = response::ajaxReturn('1','获取成功',$arr,'xml');
	
	echo $data;	