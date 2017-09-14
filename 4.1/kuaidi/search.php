<?php
	require('../function/cityKey.php');
	require('../function/httpClient.php');
	error_reporting(E_ALL & ~E_NOTICE);
	// error_reporting(E_ALL & ~E_NOTICE);
	// $com = $_GET('com');
	// $nu  = $_GET('nu');
	if(isset($_GET['com']))
	{
		$com = $_GET['com'];
	}
	if(isset($_GET['nu']))
	{
		$nu = $_GET['nu'];
	}
	$key = "8016a9ceab557496";
	$url = "http://www.kuaidi100.com/applyurl?key=".$key."&com=".$com."&nu=".$nu;
	//442412593923
	
	
	$return_url = file_get_contents($url);
	
	$ar= array('url'=>$return_url);
	// var_dump($ar);exit;
	echo json_encode($ar);
	
?>