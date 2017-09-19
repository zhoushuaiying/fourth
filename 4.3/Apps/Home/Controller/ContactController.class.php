<?php
namespace Home\Controller;


class ContactController extends CommonController
{
	public function contact_us()
    {
        if(IS_AJAX)
        {
            $info = ['code' => 0,'error' => false, 'info' => ''];
            $res  = $this -> check_verify(I('code'));

            if(!empty($res))
            {
                $leaving = M('leaving');
                $rule = array(
                    array('username','require','用户名不能为空！'),
                    array('leaving','require','内容不能为空！'),
                    array('email','/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/','请输入正确的邮箱！'),
                    array('mobile','/^1([23578])\d{9}$/','请输入正确的手机号码！'),
                );

                if($leaving -> validate($rule) -> create())
                {
                    $leaving -> addtime = time();
                    $row = $leaving -> add();
                    if($row > 0)
                    {
                       $info['code'] = 1 ;
                       $info['error']= true;
                       $info['info'] = '留言上传成功';
                       $this -> ajaxReturn($info);
                    }
                    else
                    {
                        $info['info'] = '留言保存失败!';
                        $this -> ajaxReturn($info);
                    }
                }
                else
                {
                    $info['info'] = '留言保存失败!';
                    $this -> ajaxReturn($info);
                }

            }
            else
            {
                $info['info'] = '验证码错误';
                $this -> ajaxReturn($info);
            }
        }
        else
        {
            $this -> display();
        }
    }


    public function verify()
    {
        $config = array(
            'fontSize' => 25, // 验证码字体大小
            'length'   => 4, // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
            'imageH'   => 28,

            'fontttf'  => '7.ttf',
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }


    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
}