<?php
namespace Home\Controller;

use Think\Controller;

class OrderController extends CommonController
{
    public function confirm_order()
    {

        $user_id = session('user_id');
        if(!empty($user_id))
        {
            if(IS_AJAX)
            {
                $info = ['code' => 0,'error' => false, 'info'=> ''];
                $is = !empty(I('is')) ? I('is') : 1;

                $result = I('info');
                if(empty(I('address_id')))
                {
                    $info['info'] = '还没有设置地址请先设置地址！';
                    $this -> ajaxReturn($info);
                    exit;
                }
                $data['address_id'] = I('address_id');
                $data['type']       = I('pay');

                $data['addtime']    = time();
                $data['user_id']    = $user_id;

                $order = M('order');
                $cart  = M('cart');
                foreach($result as $k => $v)
                {
                    $data['order_number'] = $v['order_number'];
                    $data['goods_id']     = $v['goods_id'];
                    $data['goods_num']    = $v['goods_num'];
                    $data['goods_color']  = $v['goods_color'];
                    $row = $order -> add($data);


                    if($row && $is == 1)
                    {
                        $cart -> delete($v['cart_id']);
                    }
                }

                if($is == 1)
                {
                    session('cart',null);
                }
                else
                {
                    session('buy_now',null);
                }

                M('address') -> where(['address_id' => I('address_id')]) -> setInc('freq');

                $info['code'] = 1;
                $info['error']= true;
                $info['info'] = $result[0]['order_number'];

                $this -> ajaxReturn($info);



            }
            else
            {
                $is = !empty(I('is')) ? I('is') : 1;
                if($is != 1)
                {
                    $data = session('buy_now');
                }
                else
                {
                    $data = session('cart');
                }

//                   dump($data);exit;


                //订单号
                $order_num = date('YmdHis').mt_rand(1000,9999).time();

                $product = M('product');
                foreach($data as $k => $v)
                {
                    $result  = $product -> where(['goods_id' => $v['goods_id']])
                        -> field('goods_name,goods_price,goods_thumb') -> find();

                    $data[$k]['goods_thumb'] = $result['goods_thumb'];
                    $data[$k]['goods_name']  = $result['goods_name'];
                    $data[$k]['goods_price'] = $result['goods_price'];
                    $data[$k]['goods_count'] = $result['goods_price']*$v['goods_num'];
                    $data[$k]['addtime']     = time();
                    $data[$k]['order_number']= $order_num;
                }

                // dump($data);exit;
                //获取地址
                $res = M('address') -> where(['user_id' => $user_id]) -> order('state asc') ->select();
//                dump($data);exit;
                $this -> assign('is',$is);
                $this -> assign('info',json_encode($data));
                $this -> assign('data',$data);
                $this -> assign('address',$res[0]);
                $this -> display();
            }

        }
        else
        {
            $this -> redirect('Home/User/login');
        }
    }
}