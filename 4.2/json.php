<?php
	
	require_once "buildData.php";
	$data = array('name'=>'zhou','age'=>22);//返回的数据
	$str  = response::json('1','获取数据成功',$data);//生成带有状态码和提示信息的json数据
	echo $str;
	