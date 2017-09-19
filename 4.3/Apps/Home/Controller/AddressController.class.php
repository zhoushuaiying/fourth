<?php
namespace Home\Controller;



class AddressController extends CommonController
{
    public function  address()
    {
        $user_id = session('user_id');

        if(!empty($user_id))
        {
            if(IS_AJAX)
            {
                $info = ['code' => 0,'error' => false, 'info'=> ''];

                $address = D('address');

                if(I('state') == 0)
                {
                    $data['state'] = 1;
                    $address -> where("address_id > 0 and user_id={$user_id}") -> save($data);

                }


                if( $address -> create())
                {

                    $address -> user_id = $user_id;
                    if($address -> add())
                    {
                        $info['code'] = 1;
                        $info['error']= true;
                        $info['info'] = '地址增添成功';
                        $this -> ajaxReturn($info);
                    }
                    else
                    {
                        $info['info'] = '地址增添失败';
                        $this -> ajaxReturn($info);
                    }


                }
                else
                {
                    $info['info'] = '数据创建失败';
                    $this -> ajaxReturn($info);
                }

            }
            else
            {
                $address = M('address');
                $history = $address -> where(['user_id' => $user_id])-> field('address_id,username,area,address,mobile,zipcode') -> order('address_id asc') -> select();

                $common  = $address -> where(['user_id' => $user_id]) -> field('address_id,username,area,address,mobile,zipcode')  -> order('state') -> limit(3) -> select();
                //默认地址id
                $addr_default = $address -> where(['state' => 0,'user_id' => $user_id]) -> find();

                $this -> assign('history',$history);
                $this -> assign('common',$common);
                $this -> assign('def',$addr_default['address_id']);
                $this -> display();

            }
        }
        else
        {

            msg('还没登录，请先登录',U('Home/User/login'));
        }


    }


    public function  addr_default()
    {
        if(IS_AJAX)
        {
            $info = ['code' => 0,'error' => false, 'info'=> ''];
            $user_id = session('user_id');

            if(!empty($user_id))
            {
                  $address    = M('address');
                  $address_id = I('address_id');

                  $result = $address -> where("address_id > 0 and user_id={$user_id}") -> save(['state' => 1]);
                  if($result > 0)
                  {
                      $res = $address -> where(['address_id' => $address_id]) -> save(['state' => 0]);

                      if($res>0)
                      {
                         $info['code'] = 1;
                         $info['error']= true;
                         $info['info'] = '设置默认地址成功!';
                         $this -> ajaxReturn($info);
                      }
                      else
                      {
                          $info['info'] = '设置默认地址失败!';
                          $this -> ajaxReturn($info);
                      }
                  }
                  else
                  {
                      $info['info'] = '设置默认地址失败!';
                      $this -> ajaxReturn($info);
                  }

            }
            else
            {
                $info['code'] = 2;
                $info['info'] = '请先登录';
                $this -> ajaxReturn($info);
            }
        }
    }


    public function  addr_del()
    {
        if (IS_AJAX) {
            $info = ['code' => 0, 'error' => false, 'info' => ''];
            $user_id = session('user_id');

            if (!empty($user_id)) {
                $address = M('address');
                $result = $address->delete(I('address_id'));

                if ($result > 0)
                {
                    $info['code'] = 1;
                    $info['error']= true;
                    $info['info'] = '地址删除成功!';
                    $this -> ajaxReturn($info);
                }
                else
                {
                    $info['info'] = '地址删除失败!';
                    $this -> ajaxReturn($info);
                }


            } else {
                $info['code'] = 2;
                $info['info'] = '请先登录';
                $this->ajaxReturn($info);
            }
        }
    }
}