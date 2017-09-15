<?php
	
	//推送数据表
	create table wx_xml_data(
		id int(10) not null auto_increment,
		xml text comment '推送的代码',
		primary key(id)
	)engine=MYISAM default charset=utf8;

	//错误日志表
	create table wx_error_log(
		id int(10) not null auto_increment,
		errcode int(10) default '0' comment '错误码',
		errmsg varchar(255) default '' comment '错误消息',
		createtime int(10) default '0' comment '错误创建时间',
		primary key(id)
	)engine=MYISAM default charset=utf8 comment '微信开发错误记录表';
