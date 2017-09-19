<?php
namespace Admin\Controller;



class MemberController extends CommonController
{
   public function showlist()
   {
   			$user_name = trim(I('user_name'));
			$user = M('user'); 			
			$map['username|realname'] = array('like','%'.$user_name.'%');
			$count = $user->where($map)  ->count();// 查询满足要求的总记录数
			// dump($count);exit;
			$Page = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$Page->parameter = ['user_name'=>$user_name,'realname'=>$user_name];
			
			$Page->setConfig('header', '<span class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</span>');
			$Page->setConfig('prev', '上一页');
			$Page->setConfig('next', '下一页');
			$Page->setConfig('last', '末页');
			$Page->setConfig('first', '首页');
			$Page->setConfig('theme', '%HEADER%&nbsp;&nbsp;&nbsp;%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%');
			$Page->lastSuffix = false;//最后一页不显示为总页数
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $user-> where($map)-> order('user_id')->limit($Page->firstRow.','.$Page->listRows)->select();
			
			// dump($list);
			// dump($show);
			// dump($count);
			// exit;
			$this -> assign('count',$count); //数据数量
			$this -> assign('member',$list);// 赋值数据集
			$this -> assign('page',$show);// 赋值分页输出
			$this -> display(); // 输出模板

   		
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
		 $user = M('user');
		 $result  = $user -> delete($select);
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