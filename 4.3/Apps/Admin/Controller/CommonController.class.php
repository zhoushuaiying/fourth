<?php
namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
	public function __construct()
	{
		
		parent::__construct();
		
		$nowc = CONTROLLER_NAME.'-'.ACTION_NAME;
		
		$login_ac = 'manager-login,manager-logout,manager-verify,Index-index,Config-uploader,Config-get_upload';
		 // $js = <<<EOF
			// <script text="javascript">
				// $moduleurl = __MODULE__;
				// window.top.location.href="{$moduleurl}/manager/login";
			// </script>			
	
// EOF;	
		$admin_id   = session('admin_id');
		$admin_name = session('admin_name');	
		
		// $admin_id   = 6;
		// $admin_name = 'qewq';
		
		if(empty($admin_id) && stripos($login_ac,$nowc) === false)
		 {
					 
			// echo $js;
			 $this -> redirect('manager/login');
			 exit;
		 }
		 
		 // 通过admin_id 查询用户的角色以及权限
		$role_ids = M('manager_role') -> where(['manager_id' => $admin_id]) -> field('role_id') -> select();
		
		$role_ids = implode(',',array_column($role_ids,'role_id'));
		$where['role_id'] = array('in',$role_ids);
		
		
		$auth_ids = M('role_auth') -> where($where) -> field('auth_id') -> select();
		// dump($auth_ids );exit;
		$auth_ids = implode(',',array_unique(array_column($auth_ids,'auth_id')));
		
		$where = array();
		$where['auth_id'] = array('in',$auth_ids);
		$res = M('auth') -> where($where) -> field("concat(auth_controller,'-',auth_action) as ids" ) -> select();
		$res = array_column($res,'ids');
		foreach($res as $k => $val)
		{
			if($val == '-')
			{
				unset($res[$k]);
			}
		}
		
		
	    $allow_ac=implode(',',$res);
		if($admin_name != 'admin' )
		{
			if(stripos($allow_ac,$nowc) === false && stripos($login_ac,$nowc) ===false)
			{
				exit('没有权限访问!');
			}
			
		}
		
	////////////////////////////////////////////////////	
		// $admin_id   = session('admin_id');
		// $admin_name = session('admin_name');	

		// $role_ids = M('manager_role') -> where(['manager_id' => $admin_id]) -> field('role_id') -> select();
		
		// $role_ids = implode(',',array_column($role_ids,'role_id'));
		// $where['role_id'] = array('in',$role_ids);
		
		
		// $auth_ids = M('role_auth') -> where($where) -> field('auth_id') -> select();
		// // dump($auth_ids );exit;
		// $auth_ids = implode(',',array_unique(array_column($auth_ids,'auth_id')));
		
		if($admin_name == 'admin')
		{
			$list = M('auth') ->where(['auth_pid' => 0]) -> select();
			foreach($list as $k => $val)
			{
				$where1['auth_pid'] = $val['auth_id'];
				$where1['auth_type']= 1;
				$list[$k]['son']   = M('auth') ->where($where1) -> select();
					
			}
			
		}
		else
		{
			$where1['auth_pid'] = 0;
			$where1['auth_id']  = array('in',$auth_ids);
			$list = M('auth') ->where(['auth_pid' => 0]) -> select();
			foreach($list as $k => $val)
			{
				$where1['auth_pid'] = $val['auth_id'];
				$where1['auth_type']=1;
				$where1['auth_id']  = array('in',$auth_ids);
				$list[$k]['son'] = M('auth') ->where($where1) -> select();
			}
		}
		// dump($list[0]);exit;
		$this -> assign('menu_list',$list);

		// dump($allow_ac); exit;
	}
}