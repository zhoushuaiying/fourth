<?php
	/*define('SMARTY_DIR','./Smarty/');
	include_once SMARTY_DIR.'Smarty.class.php';

	$smarty                 = new Smarty;
	$smarty -> template_dir = "./templates";
	$smarty -> compile_dir  = './templates_c';
	$smarty -> config_dir   = './configs';
	$smarty -> cache_dir    = './cache';*/


require_once("./smarty_common.class.php");

	$smarty = new smarty_common;
	$smarty -> assign('name','man');
	$smarty -> assign('sex','man');
	$smarty -> assign('age',70);


	$smarty->assign('cust_ids', array(1000,1001,1002,1003));
$smarty->assign('cust_names', array(
                                'Joe Schmoe',
                                'Jack Smith',
                                'Jane Johnson',
                                'Charlie Brown')
                              );
$smarty->assign('customer_id', 1001);

	$smarty -> display('sub.tpl'); 	

	// $str = $smarty -> fetch('index.tpl');
	// file_put_contents("1.txt", $smarty);
