<?php
define('SMARTY_DIR','./Smarty/');
include_once SMARTY_DIR.'Smarty.class.php';

/**
*  
*/
class smarty_common extends Smarty
{
	
	function __construct()
	{
		parent::__construct();
		$this -> setTemplateDir('./templates');
		$this -> setCompileDir('./templates_c');
		$this -> setConfigDir('./configs');
		$this -> setCacheDir('./cache');

		// $this -> left_delimiter ="{!";
		// $this -> right_delimiter ="!}";
	}
}