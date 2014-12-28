<?php
class indexController extends Controller {
	public function index() {
		if (isset($_SESSION['login']) && $_SESSION['login'] == TRUE) {
			$user = $this ->model('user','user');
			$user_id = $user ->fetch('email', $_SESSION['email']);
			$conf = $this ->model('conf','conf');
			//print_r($user);
			$conf ->fetch('user_id', $user ->_data['User_id']);
			$this ->assign('title',$conf ->_data['conf_title']);
			$this ->assign('description',$conf ->_data['description']);
			$this ->assign('nickname',$conf ->_data['nickname']);
			$this ->assign('background',$conf ->_data['background']);
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