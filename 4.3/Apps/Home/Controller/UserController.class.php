<?php
namespace Home\Controller;

use Think\Controller;

class UserController extends CommonController
{
	public function register()
	{
		if(IS_AJAX)
		{
			$info = ['code' => 0,'error' => false, 'info' => ''];
			$res  = $this -> check_verify(I('code'));			
			
            if($res)
			{
				$user = D('user');
				if($user -> create())
				{
					if($user -> add()>0)
					{
						$info['code'] = 1;
						$info['error']= false;
						$info['info'] = '注册成功';
						$this -> ajaxReturn($info);
					}
					else
					{
						$info['info'] = '注册添加失败';
						$this -> ajaxReturn($info);
					}
						
				}
				else
				{
					$info['info'] = $user -> getError();
				    $this -> ajaxReturn($info); 
				}	
				
			}
			else
			{
				$info['info'] = '验证码错误';
				$this -> ajaxReturn($info);
			}
		}
		else
		{
			
			$this -> display();
			
		}	
	}	
	
	public function login()
	{
		if(IS_AJAX)
		{



			$info = ['code' => 0,'error' => false, 'info' => ''];
			
			$user = D('user');
			$data = $user -> user(I('username'),I('pwd'));
			
			if($data['code'] == 1)
			{
				session('user_id', $data['info']['user_id']);
				session('user_name',$data['info']['username']);

			    if(I('check') == 1)
                {
                    cookie('user_name',I('username'),3600*24*3);
                    cookie('user_pwd',I('pwd'),3600*24*3);
                }

				$info['code'] = 1;
				$info['erroe']= true;
				$info['info'] = '登陆成功';
				$this -> ajaxReturn($info);	
			}
			else
			{
				$info['info'] = $data['info'];
				$this -> ajaxReturn($info);
			}	
		}
		else
		{
			$this -> display();
		}
		
		
	}
	
	public function logout()
	{
		session('[destroy]');
		$this ->redirect('login');
		
	}
	
	
	
	 public function verify()
    {
        $config = array(
            'fontSize' => 25, // 验证码字体大小
            'length'   => 4, // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
			'imageH'   => 28,
			
			'fontttf'  => '7.ttf',
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }
	
	
	function check_verify($code, $id = ''){
		$verify = new \Think\Verify();
		return $verify->check($code, $id);
	}

}