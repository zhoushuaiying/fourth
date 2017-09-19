<?php
namespace Home\Controller;



class CenterController extends CommonController
{

    public function order()
	{	
	    $user_id = session('user_id');

	    if(!empty($user_id))
        {
            $order   = M('order as o');


            $result = $order -> field('o.goods_id,o.order_number,p.goods_thumb,p.goods_name,o.goods_num,p.goods_price,o.goods_num*p.goods_price as all_price')
                -> where(['user_id' => $user_id])
                -> join('sy_product as p on p.goods_id=o.goods_id' )
                -> order('state desc')
                -> select();
//            dump($result);exit;
            $this ->assign('orders',$result);
            $this -> display();
        }
        else
        {
            $this -> redirect(U('Home/User/login'));
        }


    }


    public function order_details()
    {
        $user_id = session('user_id');

        if(!empty($user_id))
        {
            $order  = M('order as o');
            $number = I('id');
            if(empty($number))
            {
                $number = $order -> order('addtime desc') -> field('order_number') ->limit(1) ->find();
                $number = $number['order_number'];
            }


            //sy_order,sy_product,sy_address多表联查
            $result = $order
                        -> field('o.goods_id,o.order_number,p.goods_thumb,
                                  p.goods_name,o.state,p.goods_price,
                                  o.goods_num*p.goods_price as all_price,
                                  a.username,a.mobile,a.address')
                        -> where(['order_number' => $number])
                        -> join('sy_product as p on p.goods_id=o.goods_id' )
                        -> join('sy_address as a on a.address_id=o.address_id')
                        -> select();

           $order  -> where(['order_number' => $number]) -> save(['whether' => 1]);

            $money = 0;

            foreach ($result as $k => $v )
            {
                $money += $v['all_price'];

            }
//            dump($result);

            $this -> assign('orders',$result);
            $this -> assign('money',$money);
            $this -> display();
        }
        else
        {
            $this -> redirect(U('Home/User/login'));
        }




    }
    public function user()
    {

        $user_id = session('user_id');

        if(!empty($user_id))
        {
            $order = M('order as o');

            $result = $order -> distinct(true)-> field('order_number') -> where(['o.user_id' => $user_id]) -> order('addtime desc') -> limit(10)->select();
            $result = array_column($result,'order_number');
            $res='';
            foreach ($result as $k => $v)
            {
                $res[] = $order
                    -> field('o.addtime,o.order_number,o.state,
                           a.username')
                    -> where(['order_number' => $v])
                    -> join('sy_address as a on a.address_id=o.address_id')
                    // ->fetchSql(true)
                    -> find();
                // dump($res);   
                $list = $order ->   where(['order_number' => $v]) -> select();

                $price_all = 0;

                foreach ($list as $key=>$val)
                {
                    $price = $order
                        -> field('o.goods_num*p.goods_price as all_price')
                        -> where(['order_number' => $val['order_number']])
                        -> join('sy_product as p on p.goods_id=o.goods_id' )
                        -> find();

                    $price_all += $price['all_price'];

                }

                $res[$k]['price_all'] = $price_all;
            }

            $state[] = $order -> where(['user_id' => $user_id,'state' => 0]) ->field('count(*) as how') -> find();
            $state[] = $order -> where(['user_id' => $user_id,'state' => 1]) ->field('count(*) as how') -> find();
            $state[] = $order -> where(['user_id' => $user_id,'state' => 2]) ->field('count(*) as how') -> find();
            $state[] = $order -> where(['user_id' => $user_id,'state' => 3]) ->field('count(*) as how') -> find();

            $this -> assign('state',$state);
            $this -> assign('orders',$res);
            $this -> display();
        }
        else
        {
            $this -> redirect(U('Home/User/login'));
//                msg('还没有登录请先登录',U('Home/User/login'),5);
        }

    }
	
	public function viewed()
    {   
        $user_id = session('user_id');

        if(!empty($user_id))
        {
            $order   = M('order as o');


            $result = $order -> field('o.goods_id,o.order_number,p.goods_thumb,p.goods_name,o.goods_num,p.goods_price,o.goods_num*p.goods_price as all_price')
                -> where(['user_id' => $user_id,'whether' => 1])
                -> join('sy_product as p on p.goods_id=o.goods_id' )
                -> order('state desc')
                -> select();
//            dump($result);exit;
            $this ->assign('orders',$result);
            $this -> display();
        }
        else
        {
            $this -> redirect(U('Home/User/login'));
        }


    }

}