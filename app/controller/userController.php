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
		$user ->fetch('User_id', 1);
		$user ->set('password', '123456789');
		echo $user ->update('User_id', 1);
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
		echo "Login!";
	}
	
	public function logout() {
		$_SESSION['login'] = FALSE;
		echo "Logout!";
	}
	
/**	
	private inputArray;
	
	public function __construct() {
	    session_start();
		
		$json = file_get_contents("php://input");
		$inputArry = json_decode($json,TRUE);
		
		$this ->inputArray = $inputArray;
	
	}
	
    /**
	*	处理注册
	*/
	public function register() {
	    $inputArray = $this ->inputArray;
		//print_r($inputArray);
	    $user = $this ->model('user','user');
		if ($user -> fetch('email', $inputArray['email']) == "No result") {
			$user ->set('email', $inputArray['email']);
			$user ->set('password', $inputArray['pwd']);
			$user ->set('status', 1);
			
			if($user ->add() == "Failed") {
			   echo "<script>alert('Add user failed.'); history.go(-1);</script>";
			}
			
		    $_SESSION(login) = TRUE;	
	    else
		    echo "<script>alert('This user existed.'); history.go(-1);</script>";
	
	}
    /**
	*	处理登录
	*	提交数据格式：
	*	{
	*		"email": "test@test.com",
	*		"pwd": "123456789"
	*	}
	*/	
	public function login() {
		$inputArray = $this ->inputArray;
		//print_r($inputArray);
		$user = $this ->model('user', 'user');
		
		if ( $user -> fetch('email', $inputArray['email']) == "Success!") {
			if ($user ->_data['password'] == $inputArray['pwd']) {
				$_SESSION['login'] = TRUE;
			}
		    else { 
				echo "<script>alert('Incorrect password'); history.go(-1);</script>";
			}	
		}
	    else {
            echo "<script>alert('Email not exists'); history.go(-1);</script>";
        }
		
	}
    /**
	*	处理忘记密码
	*	提交数据格式：
	*	{
	*		
	*		
	*	}
	*/
    public function forgetpass() {
	
	
	
	}
    /**
	*	处理注销
	*/	
	public function logout() {
	    $_SESSION(login) = FALSE;
	    unset($_SESSION(login)); 
	}
    /**
	*	处理更改密码
	*
	*	提交数据格式：
	*	{
	*		"email": "test@test.com",
	*		"oldpwd": "123456789"
	*       "newpwd": "123456"
	*	}
	*/	
	public function changepass() {
		$inputArray = $this ->inputArray;
		//print_r($inputArray);
	    $user = $this ->model('user','user');
		if ( $user -> fetch('email', $inputArray['email']) == "Success!") {
			if ($user ->_data['password'] == $inputArray['oldpwd']) {
			$user ->set('password', 'inputArray('newpwd')');
		    $user ->update('email', $inputArray['email']);
			
			else (
			   echo "<script>alert('incorrect oldpassword'); history.go(-1);</script>";
			)
				
	
	}
	
	
	
}
?>	
}
?>
