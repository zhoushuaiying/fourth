<?php
namespace Home\Controller;


class BrandController extends CommonController
{

    public function brand_intro1()
	{	

	    $brand = M('brand');

	    $result = $brand -> field('content') -> where(['state' => 1]) -> find();
        if(!empty($result))
        {
            $result = $brand -> field('content') ->order('addtime desc') -> find();
        }
        $result = htmlspecialchars_decode($result['content']);
//        dump($result);exit;
	    $this -> assign('brand',$result);
		$this -> display();
    }

    public function brand_intro()
    {

        $brand = M('brand');

        $result = $brand -> field('content') -> where(['state' => 1]) -> find();
        if(!empty($result))
        {
            $result = $brand -> field('content') ->order('addtime desc') -> find();
        }
        $result = htmlspecialchars_decode($result['content']);
//        dump($result);exit;
        $this -> assign('brand',$result);
        $this -> display();
    }



}