<?php
namespace Admin\Controller;

use Think\Controller;


class ProductController extends CommonController
{
	public function showlist()
	{	

		// if(IS_POST||IS_GET)
		// {
			// 模糊搜索 like %
			// SELECT * from sy_product where goods_name like '%风%'
			// 模糊搜索 like _ (占位符,一个_ 占一位)
			// SELECT * from sy_product where goods_name like '_风'
			//模糊搜索 rlike 正则表达式
			// SELECT * from sy_product where goods_name rlike '.*小.*'
			//模糊搜索 regexp 正则表达式
			// SELECT * from sy_product where goods_name regexp '.*小.*'
			$goods_name = trim(I('goods_name'));
			$pro = M('product as a'); 			
			$map['goods_name|goods_introduct'] = array('like','%'.$goods_name.'%');
			$count = $pro->where($map) ->count();// 查询满足要求的总记录数
			$Page = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$Page->parameter = ['goods_name'=>$goods_name,'goods_introduct'=>$goods_name];
			
			$Page->setConfig('header', '<span class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</span>');
			$Page->setConfig('prev', '上一页');
			$Page->setConfig('next', '下一页');
			$Page->setConfig('last', '末页');
			$Page->setConfig('first', '首页');
			$Page->setConfig('theme', '%HEADER%&nbsp;&nbsp;&nbsp;%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%');
			$Page->lastSuffix = false;//最后一页不显示为总页数
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $pro-> where($map)-> field('goods_id,goods_name,category_name,goods_category,goods_num,goods_price,addtime') -> order('goods_id') -> join('sy_category as b  on b.category_id = a.goods_category')  ->  order('goods_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			
			// dump($list);
			// dump($show);
			// dump($count);
			// exit;
			$this -> assign('count',$count); //数据数量
			$this -> assign('pro',$list);// 赋值数据集
			$this -> assign('page',$show);// 赋值分页输出
			$this -> display(); // 输出模板
		// }
		// else
		// {
			// $pro = M('product as a');
			// $count = $pro->count();// 查询满足要求的总记录数
			// $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			// $Page->setConfig('header', '<span class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</span>');
			// $Page->setConfig('prev', '上一页');
			// $Page->setConfig('next', '下一页');
			// $Page->setConfig('last', '末页');
			// $Page->setConfig('first', '首页');
			// $Page->setConfig('theme', '%HEADER%&nbsp;&nbsp;&nbsp;%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%');
			// $Page->lastSuffix = false;//最后一页不显示为总页数
			// $show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			// $list = $pro-> field('goods_id,goods_name,category_name,goods_num,goods_price,addtime') -> order('goods_id') -> join('sy_category as b  on b.category_id = a.goods_category')  ->  order('goods_id')-> limit($Page->firstRow.','.$Page->listRows)->select();
			
			// $this -> assign('count',$count); //数据数量
			// $this -> assign('pro',$list);// 赋值数据集
			// $this -> assign('page',$show);// 赋值分页输出
			// $this -> display(); // 输出模板
		// }
		
		
	}
	
	public function append()
	{
		if(IS_AJAX)
		{
			 //ajax返回的信息格式	
			 $info     = ['code' => 0, 'error' => false, 'info' => ''];

			 //实例化product模型
			 $product  = D('product');
			 
			 //根据表单提交的POST数据创建数据对象
			 if($product -> create())  
			 {
				 
				  //图片上传
				  $result   = $this -> get_upload();
				  if($result['code'] == 1)
				  {
					  $result_path = $result['info'];
					 
					  foreach($result_path as $k=>$v)
					  {
						  $result_path_r[]=ltrim($v,'\.');
					  }
					  // var_dump($result_path_r);exit;
					  $product  -> goods_pic   = implode(',',$result_path_r);
					  
					  //图片缩放
					  $savePath = $this -> get_thumb($result_path[0],240);
					  if(!empty($savePath))
					  {
						  $product -> goods_thumb = ltrim($savePath,'\.');	
						  //插入数据
						  $res = $product -> add();
						  if($res)
						  {
							  $info['code'] = 1;
							  $info['error']= true;
							  $info['info']	= '商品信息添加成功!';
							  $this -> ajaxReturn($info);
						  }
						  else
						  {
							  $info['info'] = '商品信息添加失败!';
							  $this -> ajaxReturn($info);
						  }							  
					  }
					  else
					  {
						  $info['info'] = '图片缩放失败!';
						  $this -> ajaxReturn($info);
					  }			
				  }
				  else
				  {
					  $info['info'] = $result['info'];
					  $this -> ajaxReturn($info);
				  }
			 }
			 else
			 {
				 $info['info'] = $product -> getError();
				 $this -> ajaxReturn($info);
			 } 
	
		}
		else
		{
			//A方法 R方法(跨控制器的访问)
			//D M I U  
			$category = A('Admin/Category');
			// $list = $category -> get_List();
			$list = R('Admin/Category/get_List');
		
			$this -> assign('category',$list);
			$this -> display();
		}		
		
	}
	
	public function edit()
	{
		
		if(IS_AJAX)
		{
			 //ajax返回的信息格式	
			 $info     = ['code' => 0, 'error' => false, 'info' => ''];

			 //实例化product模型
			 $product  = D('product');
			 
			 //根据表单提交的POST数据创建数据对象
			 if($product -> create())  
			 {
				 $product -> updatetime  = time();
				 // dump($product);exit;
				  //图片上传
				  $result   = $this -> get_upload();
				   
				  if($result['code'] == 1)
				  {
					
					  $result_path = $result['info'];
					  foreach($result_path as $k=>$v)
					  {
						  $result_path_r[]=ltrim($v,'\.');
					  }
					  // var_dump($result_path_r);exit;
					  $product  -> goods_pic   = implode(',',$result_path_r);
					  
					  //图片缩放
					  $savePath = $this -> get_thumb($result_path[0],240);
					  if(!empty(savepath))
					  {
						  $product -> goods_thumb = ltrim($savePath,'\.');
						  //插入数据updatetime
						  
						 
						  $res = $product -> save();
						  if($res)
						  {
							  $info['code'] = 1;
							  $info['error']= true;
							  $info['info']	= '商品信息添加成功!';
							  $this -> ajaxReturn($info);
						  }
						  else
						  {
							  $info['info'] = '商品信息添加失败!';
							  $this -> ajaxReturn($info);
						  }							  
					  }
					  else
					  {
						  $info['info'] = '图片缩放失败!';
						  $this -> ajaxReturn($info);
					  }			
				  }
				  else
				  {
						 // dump($as);exit;
						$res = $product -> save();
							
						  if($res)
						  {
							  $info['code'] = 1;
							  $info['error']= true;
							  $info['info']	= '商品信息更新成功!';
							  $this -> ajaxReturn($info);
						  }
						  else
						  {
							  $info['info'] = $product -> getError();
							  $this -> ajaxReturn($info);
						  }	
				  }
			 }
			 else
			 {
				 $info['info'] = $product -> getError();
				 $this -> ajaxReturn($info);
			 } 
	
		}
		else
		{
		$product = M('product') -> find(I('id'));
		$product['goods_pic']     = ltrim($product['goods_pic'],'.');
		$product['goods_content'] = htmlspecialchars_decode($product['goods_content']); 
		$product['goods_pic']     = explode(',',$product['goods_pic']);
        $product['goods_colors']  = explode(',',$product['goods_colors']);
		$list = R('Admin/Category/get_List');

//		dump($product);exit;
		$this -> assign('category',$list);
		$this -> assign('product',$product);
		$this -> display();
		}
	}
	
	
	public function del()
	{
		if(is_array(I('id')))
		{
			$select = implode(',',I('id'));
		}
		else
		{
			$select = I('id');
		}
		// file_put_contents('del.txt',$select);
		 $product = M('product');
		 $result  = $product -> delete($select);
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
	
	protected function get_upload()
	{
		$path = './Public/Admin/img/';
			if(!file_exists($path))
			{
				mkdir($path,0777,true);
				$path=rtrim($path,'/').'/';
			}
			$config = array(
			//限制文件上传大小
			'maxSize'  => 3145728,
			//设置保存目录
			'rootPath' => $path,
			//设置上传文件的保存名称
			'saveName' => array('uniqid',''),
			//设置上传图片大格式
			'exts'     => array('jpg', 'gif', 'png', 'jpeg'),
			'autoSub'  => true,
			'subName'  => array('date','Ymd'),
			);

			$upload = new \Think\Upload($config);// 实例化上传类
			$info = $upload -> upload();
			$inf=['code' => 0,'info' => ''];	
			if(!$info)
			{
				$inf['info'] = $upload -> getError();
				return $inf;
			}
			else 
			{
				$result = [];
				foreach($info as $val)
				{
					
					$result[]=$path.$val['savepath'].$val['savename'];
				}
				
				$inf['code'] = 1;
				$inf['info'] = $result;
				
				return  $inf;
			}	
	}
	
	protected function get_thumb($path,$size)
	{
		
		// dump($result);
		
		//缩放
		
		$savePath = substr($path,0,strrpos($path,'/')+1).$size.'_'.substr($path,strrpos($path,'/')+1); 
		
		// var_dump($savePath);
		$image = new \Think\Image();
		$image -> open($path);
		// $image->thumb(150, 150)->save('./thumb.jpg');
		$image -> thumb($size,$size) -> save ($savePath);	
		
		return $savePath;
	}
	
}