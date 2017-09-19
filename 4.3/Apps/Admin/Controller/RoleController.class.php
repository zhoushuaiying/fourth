<?php
namespace Admin\Controller;



class RoleController extends CommonController
{
	public function showlist()
	{
		
		$role = M('role');	
		$result = $role -> select();
		$this -> assign('role',$result);
		
		$this -> display();
		
	}
	
	public function append()
	{
		if(IS_AJAX)
		{	
	
		
			$info = ['code' => 0,'error' => false,'info' => ''];
			
			$rules = array(
					array('role_name','require','角色名不能为空')
			);
			
			$role = M('role');
			if($role -> validate($rules) -> create())
			{
				$role_id = $role -> add();
				
				if($role_id)
				{
					if(!empty(I('ids')))
					{
						foreach(I('ids') as $v)
						{
							$data['role_id'] = $role_id;
							$data['auth_id'] = $v;
							M('role_auth') -> add($data);
						}
						$info['code'] = 1;
						$info['error']= true;
						$info['info'] = '角色权限分配成功!';
						$this -> ajaxReturn($info);
					}
					else
					{
						$info['info'] = '角色权限不存在!';
						$this -> ajaxReturn($info);
					}	
					
					
				}
				else
				{
					//角色创建失败
					$info['info'] = $role -> getError();
					$this -> ajaxReturn($info);
				}
				
			}
			else
			{
				//数据创建失败
				$info['info'] = $role -> getError();
				$this -> ajaxReturn($info);
			}	
			
		}
		else
		{
			$list = M('auth') -> where(['auth_pid' => 0]) -> field('auth_id,auth_name') ->select();
			
			foreach($list as $k => $v)
			{
				$list[$k]['son']=$this -> get_auth($v['auth_id']);
			}
			
			$this -> assign('list',$list);
			$this -> display();
		}
	}
	
	public function edit()
	{
		if(IS_AJAX)
		{	
	
		
			$info = ['code' => 0,'error' => false,'info' => ''];
			
			$rules = array(
					array('role_name','require','角色名不能为空')
			);
			
			$role = M('role');
			
			
			if($role -> validate($rules) -> create())
			{
				$role -> save();
			
			
			
				M('role_auth') -> where(['role_id' => I('role_id')]) ->delete();
				
				if(!empty(I('ids')))
				{
					foreach(I('ids') as $v)
					{	
						$data['role_id'] = I('role_id');
						$data['auth_id'] = $v;
						M('role_auth') -> add($data);
					}
					$info['code'] = 1;
					$info['error']= true;
					$info['info'] = '角色权限更新成功!';
					$this -> ajaxReturn($info);
				}
				else
				{
					$info['info'] = '角色权限不存在!';
					$this -> ajaxReturn($info);
				}	
					
					
				
				
			}
			else
			{
				//数据创建失败
				$info['info'] = $role -> getError();
				$this -> ajaxReturn($info);
			}	
			
		}
		else
		{
			$list = M('auth') -> where(['auth_pid' => 0]) -> field('auth_id,auth_name') ->select();
			
			foreach($list as $k => $v)
			{
				$list[$k]['son']=$this -> get_auth($v['auth_id']);
			}
			
			$where['role_id'] = I('id');;
			$role = D('role') -> find(I('id'));
			$auth_ids = M('role_auth') -> where($where) -> field('auth_id') -> select();
			$auth_ids = array_unique(array_column($auth_ids,'auth_id'));
	
			$this -> assign('list',$list);
			$this -> assign('role',$role);
			$this -> assign('ids',$auth_ids);
			$this -> display();
		}
	}
	
	public function get_auth($pid = 0,&$data = array())
	{

		$result   = M('auth') -> where(['auth_pid' => $pid]) -> field('auth_id,auth_name,auth_pid') -> order('auth_id asc') -> select();	
		
		
        if($result)
        {
            foreach ($result as $val)
            {
                $data[] = $val;
                $this->get_auth($val['auth_id']);
            }
        }
        return $data;
	}
	
	  public function del()
    {
        
        $select = I('id');
       
        $role = M('role');
        $result  = $role -> delete($select);
        $info    = ['code' => 0,'error' =>  false,'info' => ''];


        if($result)
        {

        	$res = M('role_auth') -> where(['role_id' => $select])	->delete();
        	 // dump($res);exit;
        	if($res)
        	{
        		 $info['code'] = 1;
	           	 $info['error']=true;
	           	 $info['info'] ='角色彻底删除!';
	           	   $this -> ajaxReturn($info);
        	}
        	else
        	{
	  			$info['info'] = '角色删除成功,权限删除失败!';
	            $this -> ajaxReturn($info);
        	}

        }
        else
        {
            $info['info'] = '删除失败';

            $this -> ajaxReturn($info);
        }

    }
	
}