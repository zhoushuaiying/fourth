<?php
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller
{
    public function __construct()
    {

        parent::__construct();
        $user_id = session('user_id');
        if(!empty($user_id))
        {
            $addr = M('cart');

            $how  = $addr -> field('count(*) as how') -> where(['user_id' => $user_id]) -> find();
            $this -> assign('how',$how['how']);
        }

        $config = M('config');
        $data   = $config -> find();
//        dump($data);exit;
        $this -> assign('config',$data);

    }
}