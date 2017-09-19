<?php
namespace Admin\Model;

use Think\Model;

class ManageModel extends Model
{
	
	protected $tableName = 'manager';
	
	protected $_validate = array(
	    array('username','','帐号名称已经存在！',0,'unique',3),
		array('username','/^\w{4,10}$/','用户名只允许2-10位英文字母、数字或者下画线！'),
		array('pwd','require','密码不能为空'),
		array('pwd','/^\w{6,16}$/','密码只允许6-16位英文字母、数字或者下画线！'),
        array('pwd2','require','确认密码不能为空'),
        array('pwd2','pwd','确认密码不正确',0,'confirm'),
		array('mobile','require','手机号不能为空'),
        array('email','/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/','请输入正确的邮箱！'),


	);
	protected $_auto = array(
		array('addtime','time',1,'function'),
		array('pwd','crypt',3,'function'),
        array('endtime','time',2,'function'),
	);
    
}