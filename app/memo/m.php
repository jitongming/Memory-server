<?php
include('app/config/general.php');
include($config['memo_path'] . 'controller.php');
include($config['memo_path'] . 'model.php');

session_start();

$queryString = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "";

$queryArray = explode("/", $queryString);
//print_r($queryArray);

$className = isset($queryArray[1]) ? $queryArray[1] : $config['default_class'];
$methodName = isset($queryArray[2]) ? $queryArray[2] : $config['default_method'];
$param = isset($queryArray[3]) ? $queryArray[3] : "";

if (!file_exists($config['controller_path'] . $className . 'Controller.php')) {
	die("<h1>:(<br />对应的控制器" . $className ."不存在！</h1>");
}

//echo 'class:'.$className . ' method: ' . $methodName . "<br />";

include($config['controller_path'] .$className . 'Controller.php');

$className .= 'Controller';
$exe = new $className();
if ($className != $methodName) {
	$exe -> $methodName($param);
}

exit();
?>