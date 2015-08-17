<?php

/**
 * 新闻类
 *
 */
class News extends BClass {
	private $tablename = 'news';

	public $id;
	public $title;
	public $content;
	public $time;

	/**
	 * 
	 * @param [type] $openid [description]
	 *
	 * 2015年8月7日01:05:31
	 * 
	 */
	public function __construct($data=null){
		parent::__construct();

		if(is_array($data)) foreach ($data as $key => $value) {
			$this->$key = $value;
		}

		$this->tablename = $this->table_prefix.$this->tablename;
	}

	/**
	 * 	获取用户信息 by id
	 * 	
	 * @return [type] [description]
	 *
	 * 2015年8月7日01:06:11
	 * 
	 */
	public function getInfoById(){
		$sql = "SELECT * FROM `{$this->tablename}` WHERE `{$this->field_prefix}id`='{$this->id}'";
		if( ($res = $this->mysqli->query($sql)) && ($row=$res->fetch_array()) ){
			$param = $this->paramArray();
			foreach ($param as $v) {
				if(!isset($row[$this->field_prefix.$v])) continue;
				$this->$v = $row[$this->field_prefix.$v];
			}
			return true;
		}
		else{
			return false;
		}
	}

	public function getPage($start,$limit){
		$sql = "SELECT * FROM `{$this->tablename}` LIMIT {$start},{$limit}";
		$rows = array();
		$index = 0;
		$param = $this->paramArray();
		if($res = $this->mysqli->query($sql)){
			$rows[$index] = array();
			while($row = $res->fetch_array()){
				foreach ($param as $value) {
					$rows[$index][$value] = $row[$this->field_prefix.$value];
				}
				$rows[$index]["time"] = date("Y-m-d",$rows[$index]["time"]);
				$index++;
			}
		}
		return $rows;
	}

	public function add($p=null){
		$param = $this->paramArray();
		unset($param['id']);
		unset($param['time']);
		$this->time = time();
		$par = "(`{$this->field_prefix}time`";
		$val = "('".time()."'";
		foreach ($param as $value) {
			$par .= ",`{$this->field_prefix}{$value}`";
			$val .= ",'{$this->$value}'";
		}
		$sql = "INSERT INTO `{$this->tablename}` {$par}) VALUES{$val})";
		// echo $sql;die();
		if($this->mysqli->query($sql)){
			return array("num"=>1,"id"=>$this->mysqli->insert_id,"time"=>date("Y-m-d",$this->time));
		}
		else{
			return array("num"=>0);
		}
	}

	public function remove($p=null){
		$num =0;
		$sum = 0;
		if(is_array($p)){
			foreach ($p as $value) {
				$sql = "DELETE FROM `{$this->tablename}` WHERE `{$this->field_prefix}id`='{$value}'";
				if($this->mysqli->query($sql))
					$num++;
				$sum++;
			}
		}
		return array("num"=>$num,"sum"=>$sum);
	}

	public function update($p=null){
		$sql = "UPDATE  `{$this->tablename}` SET  ";
		$param = $this->paramArray();
		unset($param['id']);
		unset($param['time']);
		$flag = false;
		foreach ($param as $value) {
			if($flag) $sql .= ' , ';
			$flag=true;
			$sql .= "`{$this->field_prefix}{$value}`='{$this->$value}'";
		}
		$sql .= "WHERE  `{$this->field_prefix}id` ='{$this->id}'";
		// echo $sql;die();
		if($this->mysqli->query($sql)){
			return array("num"=>1);
		}
		return array("num" => 0);
	}

	/**
	 * [countNum description]
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 * 2015年8月7日01:33:01
	 */
	public function countNum($where=null){
		$sql = "SELECT COUNT(*) FROM `{$this->tablename}`";
		if(is_array($where)){
			$sql .= " WHERE ";
			$first = true;
			foreach ($where as $value) {
				if(!$first) $sql .= " AND ";
				$sql .= "`{$this->field_prefix}{$value}`='{$this->$value}'";
				$first = false;
			}
		}
		// echo $sql;die();
		$res=$this->mysqli->query($sql)->fetch_array();
		return $res[0];
	}

	/**
	 * 字段数组
	 * 
	 * @return array 字段信息
	 *
	 */
	public function paramArray(){
		return array(
			'id' => 'id',
			'title' => 'title',
			'content' => 'content',
			'time' => 'time'
		);
	}
}