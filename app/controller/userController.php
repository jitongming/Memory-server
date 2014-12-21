<?php
class userController extends Controller {
	// 查询测试
	public function index() {		
		$user = $this ->model('user', 'user');
		$username = $user ->fetch('email', 'xlk_zx@163.com');
		print_r($user ->_data);
		$this ->assign('username', $user ->_data['email']);
		$this ->render('user');
	}
	
	// 插入数据测试
	public function add() {
		$user = $this ->model('user', 'user');
		$user ->set('email', 'abc@abc.com');
		$user ->set('password', '987654321');
		$user ->set('status', 1);
		echo $user ->add();
	}
	
	// 删除数据测试
	public function delete() {
		$user = $this ->model('user', 'user');
		echo $user ->delete('password', '987654321');
	}
	
	// 更新数据测试
	public function update() {
		$user = $this ->model('user', 'user');
		$user ->fetch('User_id', 10);
		$user ->set('password', 'abcdef');
		echo $user ->update('User_id', 10);
	}
	
	// userConf
	public function userconf() {
		$conf = $this ->model('conf', 'conf');
		$conf ->defaultConf();
		$conf ->set('nickname', 'test');
		$conf ->set('User_id', 1);
		$conf ->add();
	}
	
	public function register() {
		
	}
	
	public function login() {
		$_SESSION['login'] = TRUE;
		$_SESSION['uid'] = $user ->_data['User_id'];
		header('Location: /memory/');
	}
	
	public function logout() {
		$_SESSION['login'] = FALSE;
		header('Location: /memory/');
	}
	
	public function forgetpass() {
		//$user ->fetch('User_id', $_SESSION['uid']);
		//if ($_POST['oldpass'] == $user ->_data['password']) {
			//$user ->set()
		//}
		echo "密码更新成功";
	}
}
?>