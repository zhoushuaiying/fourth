<?php
namespace Admin\Controller;



class CategoryController extends  CommonController
{
    public function showlist()
    {

        $data = $this -> get_List();
        $this -> assign('data',$data);
		$category = D('category');
		$count    = $category -> field("count(*) as how") -> find();
		$this -> assign('count',$count['how']);
        $this -> display();
    }

    public function append()
    {
        if(IS_AJAX)
        {
//           file_put_contents('pid.txt',I('pid'));
            $category = D('category');
            if($category -> create())
            {
               $info   = ['code' => 0, 'state' => false, 'info' => ''];
               $result = $category -> add();

                if($result)
                {
                    $info['info'] = '数据插入成功';
                    $info['code'] = 1;
                    $info['state']=true;
                    $this -> ajaxReturn($info);
                }
                else
                {
                    $info['info'] = '数据插入失败';
                    $this -> ajaxReturn($info);
                }
            }
            else
            {
                $info['info'] = '表数据创建失败！';
                $this -> ajaxReturn($info);
            }
        }
        else
		{
			$result = $this -> get_List();
			$this -> assign('result',$result);
			$this -> display();
        }
    }
    public function edit()
    {
		if(IS_AJAX)
		{	
			
			$category = M('category');
			$result   = $category -> where(['pid' => I('category_id') ]) -> find();
			
			$info = ['code' => 0, 'error' => false, 'info' => ''];
			// if($result)
			// {
			// 	//存在下级分类，禁止删除
			// 	$info['info'] = '存在下级分类，禁止编辑';
			// 	$this -> ajaxReturn($info);	
			// }
			// else
			// {
				if($category -> create())
				{	
								
					$row = $category -> save();
					if($row)
					{
					$info['code'] = 1;
					$info['error']=	true;
					$info['info'] = '修改数据成功';
					$this -> ajaxReturn($info);	
					}
					else
					{
					$info['info'] = '修改数据失败';
					$this -> ajaxReturn($info);
         			}						
				}
				else
				{
					$info['info'] = '创建数据失败';
					$this -> ajaxReturn($info);
				}	
			// }
			
		}
		else
		{
			
		$result = $this -> get_List();
		$category = M('category');
		// $res = $category -> where(['category_id' => I('id')]) -> find();
		$res = $category -> find(I('id'));
		$this -> assign('result',$result);
        $this -> assign('data',$res);		
        $this -> display();
		}
    }

    public function get_List($pid = 0, $spac =0)
    {
        static $data=array();
        $spac += 6;
        $category = M('category');
        $result   = $category -> where(['pid' => $pid]) -> field('category_id,category_name,pid') -> order('category_id asc') -> select();
        if($result)
        {
            foreach ($result as $val)
            {
                $val['category_name'] =str_repeat('&nbsp;',$spac).'|--'.$val['category_name'];
                $data[] = $val;
                $this->get_List($val['category_id'],$spac);
            }
        }
        return $data;
    }
	
	public  function del()
	{
		if(IS_AJAX)
		{
			// file_put_contents('cc.txt',I('id'));

            $category   = M('category');
            $id     = I('category_id');
            $result = false;
            if(is_array($id))
            {
                $id = implode(",",$id);
                $detail = $category-> select($id);

                $is = 0;
                foreach ($detail as $k => $v)
                {
                    $res = $category -> where(['pid' => $v['category_id']]) -> select();
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
                $detail = $category -> find($id);
                $result = $category -> where(['pid' => $detail['category_id']]) -> select();
            }




			$info = ['code' => 0, 'error' => false, 'info' => ''];
			if($result)
			{
				//存在下级分类，禁止删除
				$info['info'] = '存在下级分类，禁止删除';
				$this -> ajaxReturn($info);	
			}
			else
			{
				$row = $category -> delete($id);
				if($row > 0)
				{
					$info['code'] = 1;
					$info['error']= true;
					$info['info'] = '删除成功';
					$this -> ajaxReturn($info);
				}
				else
				{
					$info['info'] = '删除失败';
					$this -> ajaxReturn($info);
				}	
			}
		}
	}
}