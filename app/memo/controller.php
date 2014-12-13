<?php
class Controller {
	public function model($model, $dbname) {
		global $config;
		include($config['model_path'] . $model . "Model.php");
		return new $model($dbname);
	}
}
?>