<?php
return array(
 'DB_TYPE'              =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'qdm114574366.my3w.com', // 服务器地址
    'DB_NAME'               =>  'qdm114574366_db',          // 数据库名
    'DB_USER'               =>  'qdm114574366',      // 用户名
    'DB_PWD'                =>  'mysql1067571893',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    // 'DB_PREFIX'             =>  'wx_',    // 数据库表前缀

    // 'DB_TYPE'               =>  'mysqli',     // 数据库类型
    // 'DB_HOST'               =>  'localhost', // 服务器地址
    
	// 'DB_NAME'               =>  '39232dbFLjzm',          // 数据库名
 //    'DB_USER'               =>  '39232_f82763',      // 用户名
 //    'DB_PWD'                =>  'A6ZBs55I62R43qK',          // 密码
	
	// 'DB_NAME'               =>  'shop',          // 数据库名
 //   'DB_USER'               =>  'test',      // 用户名
 //   'DB_PWD'                =>  '123',          // 密码
	
    // 'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sy_',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数    
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
	
    'URL_HTML_SUFFIX'       =>  '',
    'URL_MODEL'             =>   2,
//	'SHOW_PAGE_TRACE'       =>  true,
//    全局配置方式
    'LAYOUT_ON'             =>  true,
    'LAYOUT_NAME'           =>  'Common/base',
);