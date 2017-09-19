<?php
namespace Home\Model;

use  Think\Model;

class UserModel extends Model
{
	protected $_validate = array(
								array('username','require','帐号名称必须！'), //默认情况下用正则进行验证
								array('username','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
								array('pwd','pwd2','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
								
								);
	protected $_auto = array (
								array('pwd','crypt',1,'function'),// 对password字段在新增和编辑的时候使md5函数处理
								array('addtime','time',1,'function'),
								array('endtime','time',2,'function'), // 对update_time字段在更新的时候写入当前时间戳
								);
	
	public function user($username,$pwd)
	{
			$info = ['code' => 0,'error' => false, 'info' => ''];
			
			$data = $this -> where(array('username' => $username)) -> find();
			
			if(isset($data))
			{
				if(crypt($pwd,$data['pwd'])==$data['pwd'])
				{
					$save['id'] = $data['id'];
					$save['endtime'] = time();
					$this -> save($save);
					$info['code'] = 1;
					$info['error']= true;
					$info['info'] = $data;
					return $info;
				}
				else
				{
					$info['info'] = '用户密码不对';
					return $info;
				}
			}
			else
			{
				$info['info'] = '不存在此用户';
				return $info;
			}
	}
		
}