<?php
/**
*	连接数据库
*/

include('app/config/db.php'); //包含数据库配置文件

$con = mysqli_connect($database['ip'], $database['user'], $database['pass'], $database['dbname'], $database['port']);
if (!$con) {
	die('could not connect: ' . mysql_error());
}
?>