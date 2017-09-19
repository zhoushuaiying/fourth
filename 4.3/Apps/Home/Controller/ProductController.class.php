<?php
namespace Home\Controller;

use Think\Controller;

class ProductController extends CommonController
{
	
	
    public function pro_list()
	{


	    //获取页码
		$p   = !empty(I('p')) ? I('p') : 1;
		$pageNum  = 4;
        //获取商品分类
		$category = M('category');
        $cate_list= $category -> where(['pid' => 0]) -> field('category_id,category_name') ->select();
        $cate  = !empty(I('cate')) ? I('cate') : $cate_list[0]['category_id'];

//        dump($cate);exit;
        $search = trim(I('search'));
        $pro = M('product');
        $map['goods_name|goods_introduct'] = array('like','%'.$search.'%');
        $a = $this->get_category($cate);
//        dump($a[0]['category_id']);exit;
        $cate_all[] = $cate;
        foreach ($a as $k => $v)
        {
            $cate_all[] = $v['category_id'];
        }

        if(count($cate_all)>1)
        {

            $cates = implode(',',$cate_all);

        }
        else{
            $cates = $cate;

        }

        if(empty($search))
        {
            $where = "goods_category in ({$cates})";
            //页码(跳转地址，表名，当前页数,每页显示多少条,显示多少页，查询条件)
            $page['page'] = pg('/Home/Product/pro_list','product',$p,$pageNum,3,$where,'cate',$cate);
        }
         else
        {
            $where = " goods_name like '%{$search}%'";
            //页码(跳转地址，表名，当前页数,每页显示多少条,显示多少页，查询条件)
            $page['page'] = pg('/Home/Product/pro_list','product',$p,$pageNum,3,$where,'search',$search);
            $cate = 0;

        }



        $page['list'] = $pro ->  page($p,$pageNum) -> where($where)
                        -> field(['goods_id','goods_name','goods_thumb','goods_price'])
                        -> order('goods_id desc')->select();

        foreach($page['list'] as $k=>$v)
		{
			$page['list'][$k]['goods_name'] = mb_substr($v['goods_name'],0,9,'utf-8');
		}

        $category = M('category');
        $res     = $category -> where(['pid' => 0]) ->select();

        foreach($res as $k => $v)
        {
            $res[$k]['son'] = $this -> get_category($v['category_id']);
        }



        $this -> assign('data',$page);
        $this -> assign('list',$cate_list);
        $this -> assign('category',$cate);

        $this -> display();

			
		
    }
	
	public function get_category($pid,&$result=array())
	{
	
		$list =  M('category') -> where(['pid' => $pid]) ->select();
		
		if(!empty($list))
		{	
			foreach($list as $k => $v)
			{
				$result[] = $v;
				$this -> get_category($v['category_id'],$result);
			}
		}
		
		return $result;
	}
	
	public function get_category_pid($category_id,&$result='a')
	{
	
		$list =  M('category') -> where(['category_id' => $category_id]) ->find();
		
		if(!empty($list))
		{	
			
			$result = $list;
			$this -> get_category_pid($list['pid'],$result);
			
		}
	
		return $result;
	}

    public function pro_details()
	{	
		
		$pro      = M('product');
		$goods_id = I('goods_id'); 
		if(!empty($goods_id))
		{
			$detail = $pro -> where(['goods_id' => $goods_id]) -> find();
		}
		else
		{
			$detail = $pro -> order('goods_id desc') -> find();
		}

		$detail_pid = $this -> get_category_pid($detail['goods_category']);
		$detail_pid = $detail_pid['category_id'];
		// var_dump($detail_pid);exit;
		$detail['goods_pic'] = explode(',',$detail['goods_pic']);
		// var_dump($detail);exit;
        $category = M('category');
        $cate_list= $category -> where(['pid' => 0]) -> field('category_id,category_name') ->select();
        if(!empty($detail['goods_colors']))
        {
            $detail['goods_colors'] =  explode(',',$detail['goods_colors']);
        }
        $detail['first_pid'] = $detail_pid;
        // var_dump($detail);exit;
        $this -> assign('detail',$detail);
        $this -> assign('list',$cate_list);

		$this -> display();
    }
	
	public function cart_add()
	{
		if(IS_AJAX)
		{
			$info['info'] =['code' => 0,'error' => false,'info' => ''];
			
			$user_id = session('user_id');
			
			if(!empty($user_id))
			{
				$res = M('product') -> where(['goods_id' => I('goods_id')]) -> find();
				
				if(!empty($res))
				{
					if(I('goods_num') <= $res['goods_num'])
					{
						$cart     = M('cart');
						$goods_id =I('goods_id');
						$goods_num=I('goods_num');
						$goods_color = I('goods_color');
						//查询相同商品的购物车信息
						$cart_de = $cart -> where(['user_id' => $user_id,'goods_id' => $goods_id,'goods_color' => $goods_color]) -> find();
						
						if(!empty($cart_de))
						{
							$data['goods_num']  = $cart_de['goods_num'] + $goods_num;
							$data['cart_id']    = $cart_de['cart_id'];
							$data['addtime']    = time();
							$row = $cart -> save($data);
							
							if($row > 0)
							{
								$info['code'] = 1;
								$info['error']= true;
								$info['info'] = '购物车商品更新成功!';
								$this -> ajaxReturn($info);
							}
							else
							{
								$info['info'] = '购物车添加商品更新失败!';
								$this -> ajaxReturn($info);
							}	
						}
						else
						{
							$data['user_id']  = $user_id;
							$data['goods_id'] = $goods_id;
							$data['goods_num']= $goods_num;
							$data['goods_color'] =$goods_color;
							$data['addtime']  = time();
							
							$row = $cart -> add($data);
							
							if($row > 0)
							{
								$info['code'] = 1;
								$info['error']= true;
								$info['info'] = '购物车添加商品成功!';
								$this -> ajaxReturn($info);
							}
							else
							{
								$info['info'] = '购物车添加商品失败!';
								$this -> ajaxReturn($info);
							}	
						}
						
						
							
					}
					else
					{
						$info['info'] = '购买数量超过了库存!';
						$this -> ajaxReturn($info);
					}	
				}
				else
				{
					$info['info'] = '此商品不存在!';
					$this -> ajaxReturn($info);
				}	
			}
			else
			{
				$info['code'] = 2;
				$info['info'] = '用户还没有登录!';
				$this -> ajaxReturn($info);
				
			}
			
		}
	}
	

	public function buy_now()
    {

        $user_id = session('user_id');

        if(!empty($user_id))
        {
            if(IS_AJAX)
            {
                $info['info']     = ['code' => 0,'error' => false,'info' => ''];
                $data[0]['goods_id'] = I('goods_id');
                $data[0]['goods_num']= I('goods_num');
                $data[0]['goods_color']= I('goods_color');

                session('buy_now',$data);
                $info['code'] = 1;
                $info['erro'] = true;
                $info['info'] = '';
                $this -> ajaxReturn($info);


            }
        }
        else
        {
        	$info['code'] = 2;
            $info['info'] = '还没有登录,请先登录';
            $this -> ajaxReturn($info);
        }

    }
}