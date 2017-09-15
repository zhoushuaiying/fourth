<?php
/*
	1、获取参数
	2、计算签名
	3、将算出的签名与获取的签名进行对比
	4、如果对比一致，回复echostr参数
*/

	$singnature = $_GET['signature'];
	$timestamp  = $_GET['timestamp'];
	$nonce      = $_GET['nonce'];
	$echostr    = $_GET['echostr'];
	$token      = 'akdjaklfasjfnjsafnsfkafaj';
	
	$array = array($token,$timestamp,$nonce);
	sort($array);
	$str   = implode($array); 
	$my_singnature = sha1($str);
	 if($singnature == $my_singnature)
	 {
		 echo $echostr;
	 }
	 else
	 {
		 echo '';
	 }	 
	 
	
	