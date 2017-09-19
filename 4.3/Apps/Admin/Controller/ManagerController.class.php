<?php
namespace Admin\Controller;




class ManagerController extends CommonController
{
    public  function login()
    {
        if(IS_AJAX)
        {
    //$C8Dd39G6JznPXMNd3JWeP1
            $captcha = I('captcha');
            $verify = new \Think\Verify();
            $res = $verify->check($captcha, '');
            if($res)
            {

                $user  = I('username');
                $pwd   = I('password');
                $manager = D('manager');
                $result  = $manager -> user($user,$pwd);

                $msg = array();
                $msg['state'] = 'error';
                if(isset($result))
                {
                    if($result['rules'] == 0)
                    {
                        session('admin_name',$result['username']);
                        session('admin_id',$result['id']);

                        $msg['code'] = 1;
                        $msg['info'] = '登录成功';
                        $msg['state']= 'success';
                        $this -> ajaxReturn($msg);
                    }
                    else
                    {
                        $msg['code'] = 0;
                        $msg['info'] = '此账户已被冻结了';
                        $msg['state']= 'fail';
                        $this -> ajaxReturn($msg);
                    }
                }
                else
                {
                    $msg['code'] = 0;
                    $msg['info'] = '账户或密码错误';
                    $msg['state']= 'fail';
                    $this -> ajaxReturn($msg);
                }

            }
            else
            {

                $msg['code'] = 0;
                $msg['info'] = '验证码错误';
                $msg['state']= 'fail';
                $this -> ajaxReturn($msg);
            }
        }else
        {
            $this -> display();
        }
    }


    public function logout()
    {
            session(null);

//            var_dump(U('login'));exit;
            $this -> redirect(U('login'));
//             $this -> success('',U('login'));
    }

    public function verify()
    {
        $config = array(
            'fontSize' => 16, // 验证码字体大小
            'length'   => 3, // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
            'codeSet'  => '0123456789',
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry_admin();
    }

}
