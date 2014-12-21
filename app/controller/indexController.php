<?php
class indexController extends Controller {
	public function index() {
		if (isset($_SESSION['login']) && $_SESSION['login'] == TRUE) {
			$this ->render('main');
		} else {
			$this ->render('index');
		}
	}
	public function test() {
		echo 'Hello world!';
	}
	
	public function main() {
		$this ->render('main');
	}
	
	public function memory() {
		$memo = $this ->model('memory', 'memory');
		$memo ->search("2014-12-20 11:15:16", "", 0, 10);
		print_r($memo ->_data);
	}
}
?>