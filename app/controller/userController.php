<?php
class userController extends Controller {
	public function index() {		
		$user = $this ->model('user', 'user');
		$username = $user -> fetch('User_id', '1');
		print_r($username);
		
	}
}
?>