<?php
include('app/config/general.php');

$className = isset($_GET['c']) ? $_GET['c'] : $config['default_class'];
$methodName = isset($_GET['m']) ? $_GET['m'] : $config['default_method'];
//echo $className . ' ' . $methodName;

if (!file_exists($config['controller_path'] . $className . 'Controller.php')) {
	die("<h1>:(<br />对应的控制器" . $className ."不存在！</h1>");
}

include($config['memo_path'] . 'controller.php');
include($config['controller_path'] .$className . 'Controller.php');

$exe = new $className();
if ($className != $methodName) {
	$exe -> $methodName();
}

exit();
?>