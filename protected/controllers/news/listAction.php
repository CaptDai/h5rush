<?php

/**
 * controller action class
 *
 * 新闻列表
 *
 */
class CAClass extends base {

	function construct() {
		parent::__construct();
	}

	/**
	 * 新闻列表
	 * 
	 * @return null
	 * 
	 */
	function go(){

		if(isset($_GET['get'])&&$_GET['get']==1){

			require_once("./protected/models/news.class.php");

			$newsList = new News();

			echo json_encode(array("rows"=>$newsList->getPage($_POST['start'],$_POST['limit']),"results"=>$newsList->countNum()));
			
		}
		else if(isset($_POST['saveType'])){
			$param1 = array();
            $param2 = array();

            if($_POST['saveType']==='add'){
                $param1 = array("id"=>$_POST['id'],"title"=>$_POST['title'],"content"=>$_POST['content']);
            }
            else if($_POST['saveType']==='remove'){
                $param2 = explode(',',$_POST['ids']);
            }
            else if($_POST['saveType']==='update'){
                $param1 = array("id"=>$_POST['id'],"title"=>$_POST['title'],"content"=>$_POST['content']);
            }

            require_once("./protected/models/news.class.php");

            $news = new News($param1);

           	echo json_encode($news->$_POST['saveType']($param2));
            
		}
		else{

			$pageInfo = $this->getPageInfo();

			$this->renderLayout('main','list',array('pageInfo'=>$pageInfo));

		}

	}

	/**
	 * 获取页面信息
	 *
	 * 页面标题 购物车物品数量 是否登录 JS文件
	 * 
	 * @return [type]          [description]
	 *
	 * 2015年8月7日01:51:00
	 */
	public function getPageInfo(){

		$pageInfo=array();

		$pageInfo['title'] = '新闻列表';
		$pageInfo['jsFile'] = array('list');

		
		return $pageInfo;

	}

}