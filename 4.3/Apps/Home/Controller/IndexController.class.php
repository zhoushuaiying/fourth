<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	
	public  $auth_code = array('12345','23456788');
	

    public function index(){
        $this -> display();
    }
	
	public function book_list()
	{
		$this -> display();
	}

	public function item()
	{
		$this -> display();
	}
	public function cart()
	{
		$this -> display();
	}
	public function usercenter()
	{
		$this -> display();
	}
	public function order()
	{
		$this -> display();
	}

	public function getIndexData()
	{
		$this -> auth();
		$data = $this -> indexData();
		
		$retrunData = ['code' => 1,"info" => 'adasd' ,"data" => $data];
		$this -> ajaxReturn($retrunData);	
	}
	
	
	public function checkVersion()
	{
		$this -> auth();
		$version = [
			'iso'     => 3,
			'android' => 4,
			
		];
		
		$app_version = I('get.version');
		$app_os		 = I('get.os');
		
		$arr_return  = ['code' => 0,'info' => '版本检查成功'];
		if($app_os == 'iso' || $app_os == 'android')
		{
			
			//iso系统版本检查
			if($app_os == 'iso')
			{
				
				
				
				if($app_version < $version['iso'])
				{
					$arr_return['data'] = ['update' => 1,'link' => "www"];
					
					
				}
				else
				{
					
					$arr_return['data'] = ['update' => 0,'link' => "不要升级"];
					
				}
				$this -> ajaxReturn($arr_return);

			}
			// android系统版本检查
			if($app_os == 'android')
			{	
		
				if($app_version < $version['android'])
				{
					$arr_return['data'] = ['update' => 1,'link' => "www"];
					
				}
				else
				{
					$arr_return['data'] = ['update' => 0,'link' => "不用升级"];
					
				}
				$this -> ajaxReturn($arr_return);

			}
				
			
		}
		else
		{
			$info = ['code' => 2,'info' => 'adsa'];
			$this -> ajaxReturn($info);
		}			
		
		
	}
	
	public function indexData()
	{
	    $arr = array();
		$arr['slides'] = [
			['link'  => "http://m.winxuan.com/cms/10030",
			'title' => "100-30",
			'img'   => "http://static.winxuancdn.com/topic/subject/201708/10030/640-304.jpg?201709141406"],	
			
			['link'  => "http://m.winxuan.com/cms/10030",
			'title' => "自作主张",
			'img'   => "http://static.winxuancdn.com/topic/subject/201709/djts/640-304-5.jpg?201709141406"],		
			
			['link'  => "http://m.winxuan.com/cms/10030",
			'title' => "嘻嘻嘻",
			'img'   => "http://static.winxuancdn.com/topic/subject/201708/gjs/640-304.jpg?201709141406"],	

			['link'  => "http://m.winxuan.com/cms/10030",
			'title' => "嘻嘻嘻1",
			'img'   => "http://static.winxuancdn.com/topic/subject/201708/8kxj/dz/640-304-4.jpg?201709141406"],

			['link'  => "http://m.winxuan.com/cms/10030",
			'title' => "嘻嘻嘻2",
			'img'   => "http://static.winxuancdn.com/topic/subject/201708/dxyd/640-304.jpg?201709141406"],

			
			/*['link'  => "http://m.winxuan.com/cms/10030",
			'title' => "嘻嘻嘻3",
			'img'   => "http://static.winxuancdn.com/topic/subject/201708/gjs/640-304.jpg?201709141406"],			
			
			
			['link'  => "http://m.winxuan.com/cms/10030",
			'title' => "嘻嘻嘻2",
			'img'   => "http://static.winxuancdn.com/topic/subject/201708/dxyd/640-304.jpg?201709141406"],

			
			['link'  => "http://m.winxuan.com/cms/10030",
			'title' => "嘻嘻嘻3",
			'img'   => "http://static.winxuancdn.com/topic/subject/201708/gjs/640-304.jpg?201709141406"],*/	
		];
		
		
		
		return $arr;		
	}
	
	public function auth()
	{
		$key  = I('key');
			
		if(!empty($key))
		{	
			
			if(!in_array($key,$this->auth_code))
			{
				
			
				$arr = ['code' => 1000,'info' => '授权码不正确！'];
				
				$this -> ajaxReturn($arr);
				// if($type == 'json')
				// {
					// self::json('1000','授权码不正确');
				// }
				// elseif($type == 'xml')
				// {
					// self::xml('1000','授权码不正确');
				// }
				exit;
			}	
		}
		else
		{
			$arr = ['code' => 1001,'info' => '请输入授权码！'];
				
			$this -> ajaxReturn($arr);
			exit;
		} 
	}
}