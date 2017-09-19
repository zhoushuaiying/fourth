<?php
namespace Home\Controller;

use Think\Controller;

class PayController extends CommonController
{
    public function  pay()
    {
        if(IS_AJAX)
        {

            $info = ['code' => 0,'error' => false, 'info'=> ''];

            $user_id = session('user_id');

            if(!empty($user_id))
            {

                $user = M('user');
                $order= M('order');

                $money = $user -> where(['user_id' => $user_id]) -> getField('money');

                $pay   = I('money');
                if($money >= $pay)
                {
                  $user  -> startTrans();
                  $order -> startTrans();
                  $num  =  $user  -> where(['user_id' => $user_id]) -> setDec('money',$pay);



                  $result = $order -> where(['order_number' => I('order_number')]) -> select();



                  $ids    = implode(',',array_column($result,'order_id'));



                  $map['order_id'] = array('in',$ids);
                  $map['state']    = 1;
                  $row = $order -> save($map);

                  if(!empty($row))
                  {
                      $num += 1;

                  }

                  if($num == 2)
                  {
                      $user  -> commit();
                      $order -> commit();

                      $info['code'] = 1 ;
                      $info['error']= true;
                      $info['info'] = '支付成功';

                      $this -> ajaxReturn($info);
                  }
                  else
                  {
                      $user  -> rollback();
                      $order -> rollback();

                      $info['info'] = '支付失败';
                      $this -> ajaxReturn($info);
                  }


                }
                else
                {
                   $info['info'] = '用户余额不够';
                   $this -> ajaxReturn($info);
                }

            }
            else
            {
                $info['code'] = 2;
                $info['info'] = '还没有登录，请先登录';
                $this -> ajaxReturn($info);
            }

        }
        else
        {
            $result   = M('order') -> where(['order_number' => I('id')]) -> select();
            $product  = M('product');
            $all_money = 0;
            if(!empty($result))
            {

                foreach ($result as $k => $v)
                {
                    //获取商品价格
                    $goods_price = $product -> where(['goods_id' => $v['goods_id']])
                        -> getField('goods_price');
                    //该商品的总价
                    $count       = $goods_price * $v['goods_num'];
                    $all_money   += $count;
                }


            }


            $info['order_number'] = I('id');
            $info['all_money']    = $all_money;

            $recommend = M('product') -> field('goods_id,goods_thumb') -> order('goods_id desc') -> limit(3) -> select();



            $this -> assign('info',$info);
            $this -> assign('recommend',$recommend);

            $this -> display();
        }

    }
}