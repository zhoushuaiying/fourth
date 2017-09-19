<?php
namespace Admin\Controller;



class AuthController extends CommonController
{
	public  function  showlist()
	{


		$result = $this -> get_auth(1);
		
		$this -> assign('auth',$result);
		$this -> display();
	}
	
	public function append()
	{
		if(IS_AJAX)
		{

			$rules = array(
				array('auth_name','require','权限名称不能为空'),

				array('auth_moudle','require','应用名称不能为空'),


			);

			$info = ['code' => 0,'error' => false, 'info' => ''];

			$auth=D('auth');
			if($auth -> validate($rules) -> create())
			{
				$result = $auth -> add();
				if($result)
				{
					$info['code'] =1;
					$info['error']=true;
					$info['info'] ='数据插入成功';
					$this -> ajaxReturn($info);
				}
			    else
				{
					$info['info'] = $auth -> getError();
					$this -> ajaxReturn($info);
				}
			}
			else
			{
				$info['info'] = $auth -> getError();
				$this -> ajaxReturn($info);
			}


		}
		else
		{
			// $auth   = M('auth');
			// $result = $auth -> field("auth_id,auth_name") -> select();
			$result = $this -> get_auth();
			$this -> assign('result',$result);
			
			$this -> display();
		}	
		
	}
	
	public function edit()
	{
		
		if(IS_AJAX)
		{
			$info = ['code' => 0,'error' => false,'info' => ''];
			$auth = D('auth');
			if($auth -> create())
			{
				if($auth -> save())
				{
					$info['code'] = 1;
					$info['error']= true;
					$info['info'] = '权限更新成功!';
					$this -> ajaxReturn($info);
				}
				else
				{
					$info['info'] ='权限更新失败!';
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
			$result = $this -> get_auth(0);
			
			$auth   = D('auth') -> find(I('id'));
			// dump($auth);exit;
			
			$this -> assign('result',$result);
			$this -> assign('detail',$auth);
			$this -> display();
			
		}	
	}
	
	
	public function del()
	{
		$auth = D('auth');
        $id   = I('id');
		if(is_array($id))
        {
            $id = implode(",",$id);
            $detail = $auth -> select($id);
            $is = 0;
            foreach ($detail as $k => $v)
            {
                $res = $auth -> where(['auth_pid' => $v['auth_id']]) -> select();
                if($res)
                {
                   $is = 1;
                }
            }

            if($is == 1)
            {
                $result = true;
            }
        }
        else
        {
            $detail = $auth -> find($id);
            $result = $auth -> where(['auth_pid' => $detail['auth_id']]) -> select();
        }



		$info = ['code' => 0,'error' => false,'info' => ''];
		if($result)
		{
			$info['info'] = '存在子分类，不可删除!';
			$this -> ajaxReturn($info);
		}
		else
		{
			$res = $auth -> delete($id);
			if($res)
			{
				$info['code'] = 1;
				$info['error']= true;
				$info['info'] = '分类删除成功!';
				$this -> ajaxReturn($info);
			}
			else
			{
				$info['info'] = $auth -> getError();
				$this -> ajaxReturn($info);
			}	
			
		}	
	}
	public function get_auth($a = 0,$pid = 0, $spac =0)
	{
		static $data=array();
        $spac += 6;
        $category = M('auth');
		if($a == 0)
		{
			$result   = $category -> where(['auth_pid' => $pid]) -> field('auth_id,auth_name,auth_pid') -> order('auth_id asc') -> select();	
		}
		else
		{
			 $result   = $category -> where(['auth_pid' => $pid]) -> field('auth_id,auth_name,auth_pid,auth_module,auth_action,auth_controller') -> order('auth_id asc') -> select();	
		}
        if($result)
        {
            foreach ($result as $val)
            {
                $val['auth_name'] =str_repeat('&nbsp;',$spac).'|--'.$val['auth_name'];
                $data[] = $val;
                $this->get_auth($a,$val['auth_id'],$spac);
            }
        }
        return $data;
	}
	
	
}