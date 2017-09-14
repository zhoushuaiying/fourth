<?php

class  response
{
	public static $auth_code = array('123','345');
		
	//生成json格式字符串
	public static function json($code,$info,$data=array())
	{
		
		//返回的数据
		$arr = array();
		$arr['code'] = $code;
		$arr['info'] = $info;
		$arr['data'] = $data;
		
        $str = json_encode($arr);
	    echo $str;	   
	}
	//生成xml格式字符串
	public static function xml($code,$info,$data=array())
	{	
		
		
		header("content-type:text/xml");
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		// echo '1';exit;
		echo "<root>\n";
		
		echo "<code>".$code."</code>\n";
		echo "<info>".$info."</info>\n";
		
		$xml = self::create_item($data);
		echo $xml."\n";
		echo "</root>\n";
		
	}
	
	//创建xml标签选项
	public static function create_item($arr)
	{	
		
		$xml = "";
		if(is_array($arr))
		{
			foreach($arr as $k => $v)
			{
				if(is_array($v))
				{
					$xml .= "<{$k}>\n";
					
				    $xml .= self::create_item($v);
					
					$xml .= "</{$k}>\n";
				}	
				else
				{
					
					// $xml .= "&lt;{$k}&gt;".{$v}."&lt;/{$k>}&gt;\n"; 
					$xml .= "<{$k}>";
					$xml .= $v;
					$xml .="</{$k}>\n";
				}	
			}
			
		}
		if(empty($xml))
		{
			$xml = "<data>空数据！</data>";
		}
		return $xml;
	}
	//生成借口数据
	public static function ajaxReturn($code,$info,$data=array(),$type='json')
	{
		self::auth($type);
		if($type == 'json')
		{
			$result = self::json($code,$info,$data);
		}
		elseif($type == 'xml')
		{
			$result = self::xml($code,$info,$data);
		}	
		
		return $result;
		
	}
	//授权认证
	public static function auth($type)
	{
		if(isset($_GET['key']))
		{	
			$auth=$_GET['key'];
			if(!in_array($auth,self::$auth_code))
			{
				if($type == 'json')
				{
					self::json('1000','授权码不正确');
					
				}
				elseif($type == 'xml')
				{
					self::xml('1000','授权码不正确');
				}
				exit;
			}	
		}
		else
		{
			if($type == 'json')
			{
				self::json('1000','请输入授权码');
				
			}
			elseif($type == 'xml')
			{
				self::xml('1000','请输入授权码');
			}
			exit;
		}
	}
	
}
	