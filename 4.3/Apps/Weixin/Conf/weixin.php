<?php

return array(
	"TOKEN"                 => "akdjaklfasjfnjsafnsfkafaj",
	"APPID"                 => "wx444e293a580572ec",
	"APPSECRET"             => "32f59967ebbf2b45473a1b4e7696f875",
   'DATA_CACHE_TIME'        =>  7200,      // 数据缓存有效期 0表示永久缓存
    'DATA_CACHE_PREFIX'     =>  'weixin_',     // 缓存前缀
	'MENU_CONFIG'           =>  array(
			'button' => array(
				/*array(
					'name' => '查询',
					'sub_button' => array(
						array(
						'type' => 'click',
						'name' => '天气查询',
						'key'  => '海珠'
							),
					array(
						'type' => 'click',
						'name' => '菜谱大全',
						'key'  => 'cai'
							),
						),
					
					),
				
				array(
					'type' => "view",
					'name' => '书城',
					'url'  => 'http://qxu1146440161.my3w.com/'
				),	
				array(
					'name' => '菜单',
					'sub_button' => array(
						
						array('type' => 'click','name' => '功能介绍',"key" => 'help' ),
						
						// array('type'=>'view','name'=>'人脸识别','url'=>'http://qxu1146440161.my3w.com/Weixin/Index/face'),
						array('type'=>'view','name'=>'人脸识别','url'=>'http://zshuai100.08tk.cn/Weixin/Index/face'),
						
						),
					),*/
				// array(
				// 	'type' => 'click','name' => '用户','key' => 'userinfo'
				// 	),
				array(
					  'type' => 'view',
					  'name' => '手机书店',
					  'url' => 'http://qxu1146440161.my3w.com'),
				array(
					  'type' => 'view', 
					  'name' => '家庭教育',
					  'url' => 'http://qxu1146440161.my3w.com/Index/book_list'),
				array(

					'name' => '我的地盘',
					'sub_button' => array(
							array(
								'type' => 'view',
								'name' => '用户中心',
								'url'  => 'http://qxu1146440161.my3w.com/Index/usercenter',
								),	
							array(
								'type' => 'click',
								'name' => '签到',
								'key'  => 'sign' 
									),	
							array(
								'type' => 'view',
								'name' => '我的购物车',
								'url'  => 'http://qxu1146440161.my3w.com/Index/cart',
								),
							array(
							'type' => 'view',
							'name' => '订单列表',
							'url'  => 'http://qxu1146440161.my3w.com/Index/order',
							),	
						),	
						
					),

		), 
			),
  	

);