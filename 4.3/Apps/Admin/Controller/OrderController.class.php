<?php
namespace Admin\Controller;


class OrderController extends CommonController
{
    public function showlist()
    {
        $order = M('order');
        // $count = $order -> field('count(*) as how') -> find();

        // $result = $order -> order('addtime desc') -> select();



        $order_id = trim(I('order_number'));
                   
        // $map['order_id'] = array('like','%'.$order_id.'%');
        // 
        if(empty($order_id))
        {
            $map='';    
        }
        else
        {
         $map['order_number'] = trim(I('order_number'));   
        }  
        $count = $order->where($map) ->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter = ['order_id'=>$order_id];
        // dump($map);exit;
        $Page->setConfig('header', '<span class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</span>');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%HEADER%&nbsp;&nbsp;&nbsp;%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%');
        $Page->lastSuffix = false;//最后一页不显示为总页数
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $result = $order-> where($map) -> order('addtime desc') ->limit($Page->firstRow.','.$Page->listRows)->select();






        foreach ($result as $k=>$v)
        {
            $result[$k]['username'] = M('user') -> where(['user_id' => $v['user_id']]) -> getField('username');

            $info = M('address') -> where(['address_id' => $v['address_id']]) -> find();

            $result[$k]['linkman'] = $info['username'];
            $result[$k]['address'] = $info['address'];
            $result[$k]['mobile']  = $info['mobile'];
            $result[$k]['phone']   = $info['phone'];

            $info = [];
            $info = M('product') -> where(['goods_id' => $v['goods_id']]) -> field('goods_name,goods_number') ->find();
            $result[$k]['goods_name']   = $info['goods_name'];
            $result[$k]['goods_number'] = $info['goods_number'];

        }


//        dump($result);exit;
        $this -> assign('count',$count);
        $this -> assign('orders',$result);
        $this -> assign('page',$show);
        $this -> display();
    }



    public function edit()
    {

        if(IS_AJAX)
        {
            $info  = ['code' => 0,'error' => false,'info' => ''];
            $order = M('order');
            if($a = $order -> create())
            {
                // dump($a);exit;
                $order -> endtime = time();
                $row = $order -> save();
               
                if($row > 0)
                {
                    $info['code'] = 1;
                    $info['error']= true;
                    $info['info'] = '订单修改成功!';
                    $this -> ajaxReturn($info);
                }
                else
                {
                    $info['info'] = '订单修改失败!';
                    $this -> ajaxReturn($info);
                }    
            }
            else
            {
                $info['info'] = $order -> getError();
                $this -> ajaxReturn($info);
            }   
        }
        else
        {

            $order  = M('order');
            $result = $order -> field('order_id,order_number,state') -> find(I('id'));
            $this -> assign('detail',$result);
            $this -> display();
        }    
       
          
        

    }

}