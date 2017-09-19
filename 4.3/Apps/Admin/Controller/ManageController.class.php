<?php
namespace Admin\Controller;



class ManageController extends  CommonController
{
    public function showlist()
    {
			$manager = D('manager');
			$list    = $manager -> select();
			
			
			
			$this -> assign('list',$list);
            $this -> display();
    }

    public function append()
    {
		if(IS_AJAX)
		{
			
			$info = ['code' => 0,'error' => false,'info' => ''];

			$manage = new \Admin\Model\ManageModel();
			
			if($manage -> create())
			{
				$manager_id = $manage -> add();
				if(isset($manager_id))
				{
					foreach(I('role_id') as $v)
					{
						$data['manager_id'] = $manager_id;
						$data['role_id']    = $v;	
						M('manager_role') -> add($data);
					}
					$info['code'] = 1;
					$info['error']=true;
					$info['info'] ='管理人员权限创建成功';
					$this -> ajaxReturn($info);
				}
				else
				{
					$info['info'] = $manage -> getError();
					$this ->  ajaxReturn($info); 
				}	
			}
			else
			{
                $info['info'] =  $manage -> getError();
                if(empty($info['info']))
                {
                    $info['info'] = '数据创建失败';
                }
                $this ->  ajaxReturn($info);
			}
			
			
				
			
		}
		else
		{
			$list = M('role') -> select();
			$this -> assign('list',$list);
			$this -> display();
			
		}
    }
    public function rules_change()
    {
        $info = ['code' => 0,'error' => false,'info' => ''];

        $manage = new \Admin\Model\ManageModel();


        if($manage -> create())
        {
            $row = $manage -> save();
//            dump($row);exit;
            if($row > 0)
            {
                $info['code'] = 1;
                $info['error']=true;
                $info['info'] ='管理人员启用状态修改成功';
                $this -> ajaxReturn($info);
            }
            else
            {
                $info['info'] =  $manage -> getError();
                if(empty($info['info']))
                {
                    $info['info'] = '管理人员启用状态修改失败';
                }
                $this ->  ajaxReturn($info);
            }
        }
        else
        {
            $info['info'] =  $manage -> getError();
            if(empty($info['info']))
            {
                $info['info'] = '数据创建失败';
            }
            $this ->  ajaxReturn($info);
        }
    }
    public function edit()
    {

		if(IS_AJAX)
		{
			$info = ['code' => 0,'error' => false,'info' => ''];

			$manage = new \Admin\Model\ManageModel();


			if($manage -> create())
			{

				$manager_id = $manage -> save();

				if(!empty(I('role_id')))
				{
					$s = M('manager_role') -> where(['manager_id' => I('id')]) ->delete();
					// var_dump($s);exit;
					foreach(I('role_id') as $v)
					{
						$data['manager_id'] = I('id');
						$data['role_id']    = $v;
						M('manager_role') -> add($data);
					}
					$info['code'] = 1;
					$info['error']=true;
					$info['info'] ='管理人员权限修改成功';
					$this -> ajaxReturn($info);
				}
				else
				{
                    $info['info'] =  $manage -> getError();
                    if(empty($info['info']))
                    {
                        $info['info'] = '管理人员权限修改成功';
                    }
                    $this ->  ajaxReturn($info);
				}
			}
			else
			{
                $info['info'] =  $manage -> getError();
                if(empty($info['info']))
                {
				    $info['info'] = '数据创建失败';
                }
                $this ->  ajaxReturn($info);
			}
			
			
				
		}
		else
		{
			$manager = D('manager');
			$detail = $manager -> find(I('id'));
			$list = M('role') -> select();
			
			$detail['role'] = array_column(D('manager_role') -> where(['manager_id' => $detail['id']]) ->select(),'role_id');
			
			// dump($detail);exit;
			$this -> assign('list',$list);
			$this -> assign('detail',$detail);
			$this -> display();
		}	
		
		
    }

    public function  del()
    {

        $manager = M('manager');
        $result  = $manager ->  delete(I('id'));
//        dump($select);exit;
        $info    = ['code' => 0,'error' =>  false,'info' => ''];
        if($result > 0)
        {
            $info['code'] = 1;
            $info['error']=true;
            $info['info'] ='删除成功';

            $this -> ajaxReturn($info);
        }
        else
        {
            $info['info'] = '删除失败';

            $this -> ajaxReturn($info);
        }
    }
}