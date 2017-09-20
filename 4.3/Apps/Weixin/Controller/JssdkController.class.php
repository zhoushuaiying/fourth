<?php
namespace Weixin\Controller;
use Think\Controller;
class JssdkController extends CommonController {
  
  public function nonceStr()
  {
  		$arr1 = range('a','z');
  	    $arr2 = range('A','Z');
  	    $arr3 = range('0','9');

  	    $arr = array_merge($arr1,$arr2,$arr3);

  	    $str = '';
  	    for($i = 0;$i<32;$i++)
  	    {
  	    	$str .= $arr[array_rand($arr)]; 
  	    } 		
  	    return $str;
  }


  public function  signature($noncestr,$timestamp)
  {
  	$url   = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  	$jsapi_ticket = $this -> get_jsapi_ticket(); 

  	$arr = array(
  		'noncestr' => $noncestr,
  		'timestamp'=> $timestamp,
  		'url'      => $url,
  		'jsapi_ticket' => $jsapi_ticket, 
  		);

  	ksort($arr);
  	$str = '';
  	foreach ($arr as $key => $value) {
  		$str .= '&'.$key.'='.$value;
  	}
  	$str = trim($str,'&');

  	$signature = sha1($str);
  	return $signature; 

  }

  public function get_jsapi_ticket()
  {
  	$access_token = $this -> getToken();
  	$api = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
  	$res = getRequest($api);
  	if($res['errcode'] == 0)
  	{
  		$jsapi_ticket = $res['ticket'];
  		return $jsapi_ticket;
  	}
  	
  }

}