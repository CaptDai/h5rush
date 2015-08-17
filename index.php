<?php
/**
 *
 *
 */

session_start();

date_default_timezone_set('PRC');

header('Content-Type: text/html; charset=utf-8');

!defined('BASE_PATH') && define('BASE_PATH',dirname(__FILE__)) ;

require_once('./protected/lib/conn.php');

require_once('./protected/lib/BClass.php');

require_once('./protected/lib/base.php');

require_once('./protected/lib/app.php');

$app = new app();

$app->run();
