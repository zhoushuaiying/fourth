<?php
namespace Home\Controller;



class CartController extends CommonController
{
	public function shop_cart()
	{
		if(IS_AJAX)
		{
			$info=['code' => 0,'error'=> false,'info'=>''];
			session('cart',I('data'));
			
			if(!empty(session('cart')))
			{
				$info['code'] = 1;
				$info['error']= true;
				$info['info'] = '商品选择成功';	
				$this -> ajaxReturn($info);
			}
			else
			{
				$infoi['info'] = '商品选择失败';
				$this -> ajaxReturn($info);
			}		
		}
		else
		{
			$user_id = session('user_id');

			if(!empty($user_id) )
			{
				$cart    = M('cart as c');
				$list = $cart -> join('sy_product as p on p.goods_id=c.goods_id')
                        -> where(['user_id' => $user_id])
                        -> field('c.cart_id,c.goods_num as sum,p.goods_name,
                           p.goods_id,p.goods_price,p.goods_thumb,c.goods_color')
                        -> select();
				$this -> assign('list',$list);
				$this -> display();
				U('');
			}
			else
			{
				$this -> redirect('User/login');
			}	
		}	
		
	}
	
	
	public  function del()
	{
		if(IS_AJAX)
		{
			$info['info'] =['code' => 0,'error' => false,'info' => ''];
			
			$row = M('cart') -> where(['cart_id' =>I('cart_id')]) -> delete();
			if($row > 0)
			{
				$info['code'] = 1;
				$info['error']= false;
				$info['info'] = '删除成功';
				$this -> ajaxReturn($info);
			}
			else
			{
				$info['code'] = 0;
				$this -> ajaxReturn($info);
			}	
			
		}
	}
	
//	public function confirm_order()
//	{
//
//            $user_id = session('user_id');
//            if(!empty($user_id))
//            {
//                if(IS_AJAX)
//                {
//                    $info = ['code' => 0,'error' => false, 'info'=> ''];
//
//                    $result = I('info');
//
//                    $data['address_id'] = I('address_id');
//                    $data['type']       = I('pay');
//                    $data['addtime']    = time();
//                    $data['user_id']    = $user_id;
//
//                    $order = M('order');
//                    $cart  = M('cart');
//                    foreach($result as $k => $v)
//                    {
//                        $data['order_number'] = $v['order_number'];
//                        $data['goods_id']     = $v['goods_id'];
//                        $data['goods_num']    = $v['goods_num'];
//
//                        $row = $order -> add($data);
//                        if($row)
//                        {
//                           $cart -> delete($v['cart_id']);
//                        }
//                    }
//
//                    session('cart',null);
//
//                    $info['code'] = 1;
//                    $info['error']= true;
//                    $info['info'] = $result[0]['order_number'];
//
//                    $this -> ajaxReturn($info);
//
//
//
//                }
//                else
//                {
//                    $data = session('cart');
//                    //订单号
//                    $order_num = date('YmdHis').mt_rand(1000,9999).time();
//
//                    $product = M('product');
//                    foreach($data as $k => $v)
//                    {
//                        $result  = $product -> where(['goods_id' => $v['goods_id']])
//                            -> field('goods_name,goods_price,goods_thumb') -> find();
//
//                        $data[$k]['goods_thumb'] = $result['goods_thumb'];
//                        $data[$k]['goods_name']  = $result['goods_name'];
//                        $data[$k]['goods_price'] = $result['goods_price'];
//                        $data[$k]['goods_count'] = $result['goods_price']*$v['goods_num'];
//                        $data[$k]['addtime']     = time();
//                        $data[$k]['order_number']= $order_num;
//                    }
//
//                    // dump($data);exit;
//                    //获取地址
//                    $res = M('address') -> where(['user_id' => $user_id]) -> order('state desc') ->select();
//
//                    $this -> assign('info',json_encode($data));
//                    $this -> assign('data',$data);
//                    $this -> assign('address',$res[0]);
//                    $this -> display();
//                }
//
//            }
//            else
//            {
//                $this -> redirect('Home/User/login');
//            }
//        }
		







}