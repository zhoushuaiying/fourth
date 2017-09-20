<?php

return array(
	"TOKEN"                 => "akdjaklfasjfnjsafnsfkafaj",
	"APPID"                 => "wx444e293a580572ec",
	"APPSECRET"             => "32f59967ebbf2b45473a1b4e7696f875",
   'DATA_CACHE_TIME'        =>  7200,      // 数据缓存有效期 0表示永久缓存
    'DATA_CACHE_PREFIX'     =>  'weixin_',     // 缓存前缀
	'MENU_CONFIG'           =>  array(
			'button' => array(
				array(
					'type' => 'click',
					'name' => '查询',
					'key'  => '海珠'
					),
				array(
					'name' => '一级菜单',
					'sub_button' => array(
						array('type'=>'view','name'=>'用户中心','url'=>'http://qxu1146440161.my3w.com/Weixin/Index/getUserinfo'),
						array('type'=>'view','name'=>'163','url'=>'http://www.163.com'),
						array('type'=>'view','name'=>'我','url'=>'http://qxu1146440161.my3w.com'),

						),
					),
				array(
					'type' => 'click','name' => '用户','key' => 'userinfo'
					),
				),

		), 
  	

);