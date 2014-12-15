<?php
class Controller {
	private $view = array();
	
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
	
	/**
	*	渲染模板
	*
	*/
	public function render($file) {
		global $config;
		if (!file_exists($config['view_path'] . $file . '.html')) {
			die("未在找到模版文件" . $file . '.html');
		}
		$string = file_get_contents($config['view_path'] . $file . '.html');
		
		foreach ($this ->view as $key => $value) {
			$find = '{#' . $key . '}';
			$string = str_replace($find, $value, $string);
		} 
		echo $string;
		exit();
	}
	
	/**
	*	模版赋值
	*/
	public function assign($key, $value) {
		$this ->view[$key] = $value;
	}
}
?>