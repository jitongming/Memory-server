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
}
?>