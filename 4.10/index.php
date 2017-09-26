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
	$smarty -> display('index.tpl'); 	