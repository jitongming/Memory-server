<?php
class Controller {
	/**
	*	新建一个model
	*	参数：类名，对应表名
	*/
	public function model($model, $dbname) {
		global $config;
		if (!file_exists($config['model_path'] . $model . "Model.php")) {
			die("<h1>:(<br>对应的model" . $model . "不存在！</h1>");
		}
		include($config['model_path'] . $model . "Model.php");
		return new $model($dbname);
	}
}
?>