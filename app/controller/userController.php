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
		$user = $this ->model('user', 'user');
		if ($user ->fetch('email', $_POST['email']) == 'Success!') {
			echo "该用户已存在！";
		} else {
			$user ->set('email', $_POST['email']);
			$user ->set('password', $_POST['password']);
			$user ->set('status', 1);
			$user ->add();
		}
	}
	
	public function login() {
		$user = $this ->model('user', 'user');
		if ($user ->fetch('email', $_POST['email']) && 
			$user ->_data['password'] == $_POST['password']) {
			$_SESSION['login'] = TRUE;
			$_SESSION['uid'] = $user ->_data['User_id'];
			$_SESSION['email'] = $user ->_data['email'];
			header('Location: /memory/');
		} else {
			header('Location: /memory/');
		}
	}
	
	public function logout() {
		$_SESSION['login'] = FALSE;
		$_SESSION['uid'] = 0;
		$_SESSION['email'] = '';
		header('Location: /memory/');
	}
	
	public function forgotpass() {
		$user ->fetch('User_id', $_SESSION['uid']);
		if ($_POST['oldpass'] == $user ->_data['password']) {
			$user ->set('password', $_POST['newpass']);
			echo "密码更新成功";
		} else {
			echo "密码更新失败，似乎和旧密码对不上！";
		}
	}
	
	public function userinfo() {
		echo 'Nothing!';
	}
}
?>