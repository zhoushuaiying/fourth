<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	
	public  $auth_code = array('12345','23456788');
	
	public function _initialize()
	{	
		$action = ACTION_NAME;
		$arr = array('cart','usercenter','order','myaccount');
		if(in_array($action,$arr))
		{
			$this -> checkLogin();	
		}
	}	

    public function index(){

    	header("Content-Type:text/html;charset=utf-8");
    	$product = M('product');
    	$list = $product -> limit(3) -> select(); 
    	
    	$this -> assign('pro',$list);
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
	public function myaccount()
	{
		$this -> display();
	}
	public function WeixinLogin()
	{
		$oauth = A('Weixin/Oauth');
		$userinfo = $oauth -> wxLogin();
		
		$user_type = '4';
		$openid    = $userinfo['openid'];
		session('login_type',$user_type);
		//将用户信息写入
		$user = M('user');
		$where =  array('user_type' => $user_type,'other_openid'=> $openid );
		// var_dump(json_encode($userinfo,JSON_UNESCAPED_UNICODE));exit;
		$res = $user -> where($where) -> find();
		if(!$res)
		{
			$data = [
				'addtime' => time(),
				'user_type' => $user_type,
				'other_openid' => $openid,
				// 'other_user' => serialize($userinfo)
				'other_userinfo' => json_encode($userinfo,JSON_UNESCAPED_UNICODE),
				];
			// var_dump($data);exit;
			$user -> add($data);
		}
		// $this -> redirect('usercenter');
	}
	public function logout()
	{
		session('userinfo',null);
		$this -> redirect('Index/login');
	}

	private function checkLogin()
	{	
		$userinfo = session('userinfo');
		if(!$userinfo)
		{
			$this -> redirect('Index/login');
		}


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