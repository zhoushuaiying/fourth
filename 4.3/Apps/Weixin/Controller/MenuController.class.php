<?php
namespace Weixin\Controller;
use Think\Controller;
class MenuController extends CommonController {

	//删除公众号菜单
	public function delMenu()
	{
		$token = $this -> getToken();
		$api = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$token;
		$res = getRequest($api);
		 if($res['errcode'] == 0)
		 {
		 	exit('删除成功');
		 }
	}
	//创建菜单
	public function createMenu()
	{									
		$token = $this -> getToken();
		$api   = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token;
		$menu_config = C('MENU_CONFIG');
		//在转json，不将中文进行unicode编码
		$post_config = json_encode($menu_config,JSON_UNESCAPED_UNICODE);
		$res = postRequest($api,$post_config);
		if($res['errcode']== 0)
		{
			exit('菜单创建成功');
		}
		else
		{
			exit('菜单创建失败');
		}

	}

}