<?php

/**
 * app model
 *
 */
class app extends base {

	protected $CAFileUrl;		// ./protected/controllers/{$controller}/{$action}Action.php file url

	/**
	 * 构造函数 获取ControllerActionFileUrl
	 *
	 */
	function __construct(){
		parent::__construct();

		$this->CAFileUrl = "./protected/controllers/{$this->controller}/{$this->action}Action.php";
	}

	/**
	 * require相应的action类
	 * 
	 * @return null
	 *
	 */
	function run(){
		if(!file_exists($this->CAFileUrl))
			$this->redirect();
		require_once($this->CAFileUrl);
		$CAObj = new CAClass();
		$CAObj->go();
	}

}