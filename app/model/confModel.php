<?php
class conf extends DataBaseModel {
	/**
	*	用于生成默认的用户配置
	*/
	public function defaultConf() {
		$this ->_data['conf_title'] = "no title";
		$this ->_data['nickname'] = "no nickname";
		$this ->_data['description'] = "no description";
		$this ->_data['background'] = "default.jpg";
		$this ->_data['User_id'] = 0;
	}
}
?>