<?php
namespace Admin\Controller;


class BrandController extends CommonController
{
   public function showlist()
   {
   		$brand = M('brand');
   		$data = $brand -> select();

   		foreach ($data as $key => $value) {
   			$data[$key]['content'] = mb_substr(strip_tags(htmlspecialchars_decode($value['content'])),0,20,'utf-8').'.....';
   		}

   		$count = $brand -> count();
   		
   		$this -> assign('brand',$data);
   		$this -> assign('count',$count);
   		$this -> display();	
   }

   public function append()
   {
   		if(IS_AJAX)
   		{
   			$info  = ['code' => 0,'error' => false, 'info' => ''];
   			$brand = M('brand');
   			if($a = $brand -> create())
   			{
                if($brand->state == 1 )
                {
                    $brand -> where('brand_id>0') -> save(['state' => 0]);
                }

   				$brand ->addtime = time();
   				$row = $brand ->add();

   				if($row > 0)
   				{
   					$info['code'] = 1;
   					$info['error']= true;
   					$info['info'] = '添加品牌简介成功';
   					$this -> ajaxReturn($info);
   				}
   				else
   				{
					$info['info'] = '添加品牌简介失败!';
					// $info['info'] = $brand -> getError();
					
	   				$this -> ajaxReturn($info);
   				}	
   			}
   			else
   			{
   				$info['info'] = '创建数据失败!';
   				$this -> ajaxReturn($info);
   			}	
   		}
   		else
   		{
   			$this -> display();	
   		}	
   }

   public function state_change()
   {
       $info  = ['code' => 0,'error' => false, 'info' => ''];

       $brand = M('brand');

       if($a = $brand -> create())
       {
           if($brand->state == 1 )
           {
               $brand -> where('brand_id>0') -> save(['state' => 0]);
           }

           $brand ->addtime = time();
           $row = $brand ->save();

           if($row > 0)
           {
               $info['code'] = 1;
               $info['error']= true;
               $info['info'] = '文章引用成功';
               $this -> ajaxReturn($info);
           }
           else
           {
               $info['info'] = '文章引用失败!';
               // $info['info'] = $brand -> getError();

               $this -> ajaxReturn($info);
           }
       }
       else
       {
           $info['info'] = '创建数据失败!';
           $this -> ajaxReturn($info);
       }
   }
   public function edit()
   {

       if(IS_AJAX)
       {
           $info  = ['code' => 0,'error' => false, 'info' => ''];

           $brand = M('brand');

           if($a = $brand -> create())
           {
               if($brand->state == 1 )
               {
                   $brand -> where('brand_id>0') -> save(['state' => 0]);
               }

               $brand ->updatetime = time();
               $row = $brand ->save();

               if($row > 0)
               {
                   $info['code'] = 1;
                   $info['error']= true;
                   $info['info'] = '文章修改成功';
                   $this -> ajaxReturn($info);
               }
               else
               {
                   $info['info'] = '文章修改失败!';
                   // $info['info'] = $brand -> getError();

                   $this -> ajaxReturn($info);
               }
           }
           else
           {
               $info['info'] = '创建数据失败!';
               $this -> ajaxReturn($info);
           }
       }
       else
       {
           $brad = M('brand');
           $data = $brad -> find(I('id'));
           $this -> assign('data',$data);
           $this -> display();
       }


   }

   public function del()
   {
       if(is_array(I('brand_id')))
       {
           $select = implode(',',I('brand_id'));

       }
       else
       {
           $select = I('brand_id');

       }
       // file_put_contents('del.txt',$select);
       $brand = M('brand');
       $result  = $brand -> delete($select);
       $info    = ['code' => 0,'error' =>  false,'info' => ''];
       if($result)
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