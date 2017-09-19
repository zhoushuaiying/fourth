<?php
namespace Admin\Controller;



class IndexController extends CommonController
{
    public function Index()
    {
		// $admin_id  = session('admin_id');
		// $admin_name= session('admin_name');
		
		//  // 通过admin_id 查询用户的角色以及权限
		// $role_ids = M('manager_role') -> where(['manager_id' => $admin_id]) -> field('role_id') -> select();
		
		// $role_ids = implode(',',array_column($role_ids,'role_id'));
		// $where['role_id'] = array('in',$role_ids);
		
		
		// $auth_ids = M('role_auth') -> where($where) -> field('auth_id') -> select();
		// // dump($auth_ids );exit;
		// $auth_ids = implode(',',array_unique(array_column($auth_ids,'auth_id')));
		
		// if($admin_name == 'admin')
		// {
		// 	$list = M('auth') ->where(['auth_pid' => 0]) -> select();
		// 	foreach($list as $k => $val)
		// 	{
		// 		$where['auth_pid'] = $val['auth_id'];
		// 		$where['auth_type']= 1;
		// 		$list[$k]['son']   = M('auth') ->where($where) -> select();
		// 	}
		// }
		// else
		// {
		// 	$where['auth_pid'] = 0;
		// 	$where['auth_id']  = array('in',$auth_ids);
		// 	$list = M('auth') ->where(['auth_pid' => 0]) -> select();
		// 	foreach($list as $k => $val)
		// 	{
		// 		$where['auth_pid'] = $val['auth_id'];
		// 		$where['auth_type']=1;
		// 		$where['auth_id']  = array('in',$auth_ids);
		// 		$list[$k]['son'] = M('auth') ->where($where) -> select();
		// 	}
		// }
		// // dump($list[0]);exit;
		// $this -> assign('list',$list);
        $this -> display();
    }
}