<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends CommonController 
{
	// public function _before_index()
	// {
		// return'before'.'<br>';		
	// }
	
    public function index()
	{	



		$this -> display();
    }
	
	
	// public function _after_index()
	// {
		// return 'after'.'<br/>';
	// }
}