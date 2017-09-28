<?php
/*
	添加模版
	1、在主目录: /themes/default/下面新建一个模版文件（home.dwt）
	2、打开 /admin/include/lib_template.php
	  修改：$template_files数组 添加home.dwt 
	  修改：$page_libs 数组 
	3、/languages/zh_cn/admin/template.php
		复制一份  $_LANG['template_files']['index'] = '首页模板';
		改为 $_LANG['template_files']['home'] = 'Home模板'; 
	4、/themes/default/libs.xml
		复制<file name="index.dwt">...</file>这个结构改名为home.dwt

	
	创建自己的模版
	1、创建模版目录 /themes/mypro
	2、创建图片目录 /themes/mypro/images
	3、创建缩略图   /themes/mypro/images/screenshot.png
	4、创建样式目录	/themes/mypro/style.css
		style.css内容如下(包括注释，顶格写)
		/*
		Template Name: ECSHOP Default
		Template URI: http://www.ecshop.com/
		Description: 默认升级版.
		Version: 2.7.2
		Author: ECSHOP Team
		Author URI: http://www.ecshop.com/
		Logo filename: logo.gif
		Template Type: type_0
		*/
	
/*
	5、打开ecshop后台 ，模版管理 -> 模版选择		
*/		

