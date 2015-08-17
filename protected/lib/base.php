<?php
/**
 * 基类
 *
 */
class base {

	protected $controller;
	protected $action;
	protected $g;

	protected $viewUrl;

	/**
	 * 构造函数
	 *
	 * 从URL中获取$controller $action 参数，若无参数重定向至 index/index
	 *
	 */
	function __construct(){
		isset($_GET['g'])?$this->g=$_GET['g']:$this->redirect();
		$url_param = explode('/',$this->g);
		isset($url_param[1])?0:$this->redirect();
		$this->controller=$url_param[0];
		$this->action=$url_param[1];
		isset($url_param[2])?$this->g=$url_param[2]:0;
		return ;
	}

	/**
	 * 渲染视图
	 *
	 * 视图文件： ./protected/view/{$controller}/{$action}.php
	 * 
	 * @param  array $data 	传入视图所需数据
	 * @return [type]       [description]
	 *
	 */
	function render($view,$data=null){
		if(is_array($data)) foreach ($data as $key => $value) {
			$$key=$value;
		}
		$this->viewUrl = "./protected/views/{$this->controller}/{$view}.php";
		if(!file_exists($this->viewUrl))
			$this->redirect();
		require_once($this->viewUrl);
	}

	function renderLayout($layout,$view,$data=null){
		$pageInfo = $data['pageInfo'];
		if(isset($_SESSION['usn'])){
			$pageInfo['usn'] = $_SESSION['usn'];
			require_once("./protected/models/cart.class.php");
			$cart = new Cart(array("ownerId"=>$_SESSION['usid']));
			$pageInfo['cartnum'] = $cart->countNum(array('ownerId'));
		}
		require_once("./protected/views/layout/{$layout}.php");
	}

	/**
	 * 重定向
	 * 	
	 * @param  string $url 重定向，默认为 home/index
	 * @return [type]      [description]
	 *
	 */
	function redirect($url='./?g=news/list'){
		$locat = $url;
		if(isset($_GET)&&is_array($_GET)) foreach ($_GET as $key => $value) {
			if($key=='g') continue;
			$locat .= '&'.$key.'='.$value;
		}
		header('Location: '.$locat);
	}
}