<?php

/**
 * 数据库类
 *
 */
class conn {
	private $host_name=SAE_MYSQL_HOST_M;
	private $host_username=SAE_MYSQL_USER;
	private $host_passwd=SAE_MYSQL_PASS;
	private $host_database=SAE_MYSQL_DB;
	private $host_charset='utf8';
	private $host_port=SAE_MYSQL_PORT;

	public $table_prefix = 't_';
	public $field_prefix = 'f_';
	public $mysqli;

	function __construct(){
		$this->mysqli = new mysqli($this->host_name,$this->host_username,$this->host_passwd,$this->host_database,$this->host_port);
		if($this->mysqli->errno){
			die();
		}
		$this->mysqli->set_charset($this->host_charset);
	}
}

