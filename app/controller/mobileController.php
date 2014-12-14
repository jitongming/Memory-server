<?php
class mobileController extends Controller {
	
	private $response = Array(
		'ret' => 0,
		'msg' => '',
		'data' => Array()
	);
	
	private $inputArray;
	
	public function __construct() {
		session_start();
		
		$json = file_get_contents("php://input");
		$inputArray = json_decode($json, TRUE);
		
		if ($inputArray == NULL) {
			$this ->response['ret'] = 0;
			$this ->response['msg'] = 'Bad json!';
			$this ->endResponse();
		}
		
		$this ->inputArray = $inputArray;
	}
	
	/**
	*	处理注册
	*
	*	提交数据格式：
	*	{
	*		"email": "test@test.com",
	*		"nickname": "test",
	*		"pwd": "123456789"
	*	}
	*	返回数据格式：
	*	{
	*		"ret": 0,
	*		"msg": "ok",
	*		"data": {
	*			"register":"success",
	*			"session_id":"kappn7iahhf5316nnhg1ejval3"
	*		}
	*	}
	*/
	public function register() {
		$user = $this ->model('user', 'user');
		if ($user -> fetch('email', $inputArray['email']) == "No result") {
			$user ->set('email', $inputArray['email']);
			$user ->set('password', $inputArray['pwd']);
			$user ->set('status', 1);
			
			if($user ->add() == "Failed") {
				$this ->response['ret'] = 0;
				$this ->response['msg'] = "Add user failed.";
				
				$this ->endResponse();
			}
			
			$user ->fetch('email', $inputArray['email']);
			$userId = $user ->_data['User_id'];
			
			$conf = $this ->model('conf', 'conf');
			$conf ->defaultConf();
			$conf ->set('nickname', $inputArray['nickname']);
			$conf ->set('User_id', $userId);
			//print_r($conf ->_data);
			if($conf ->add() == "Failed") {
				$this ->response['ret'] = 0;
				$this ->response['msg'] = "Add userconf failed.";
				$this ->endResponse();
			}
			
			$_SESSION['login'] = true;
			
			$this ->response['ret'] = 1;
			$this ->response['msg'] = "OK";
			$this ->response['data']['register'] = "success";
			$this ->response['data']['session_id'] = session_id();
			$this ->endResponse();
		} else {
			$this ->response['ret'] = 0;
			$this ->response['msg'] = "This user existed.";
			$this ->endResponse();
		}
		
	}
	
	/** 处理登录
	*	提交数据格式：
	*	{
	*		"email": "test@test.com",
	*		"pwd": "123456789"
	*	}
	*	返回数据格式：
	*	{
	*		"ret": 0,
	*		"msg": "ok",
	*		"data": {
	*			"id":"123434",
	*			"nickname":"guan",
	*			"session_id":"asdasdwdawd"
	*		}
	*	}
	*/
	public function login() {
		$inputArray = $this ->inputArray;
		//print_r($inputArray);
		$user = $this ->model('user', 'user');
		
		if ( $user -> fetch('email', $inputArray['email']) == "Success!") {
			if ($user ->_data['password'] == $inputArray['pwd']){
				
				$conf = $this ->model('conf', 'conf');
				$conf ->fetch("User_id", $user ->_data['User_id']);
				
				$_SESSION['login'] = TRUE;
				$this ->response['ret'] = 1;
				$this ->response['msg'] = "OK";
				$this ->response['data']['id'] = $user ->_data['User_id'];
				$this ->response['data']['nickname'] = $conf ->_data['nickname'];
				$this ->response['data']['session_id'] = session_id();
				$this ->endResponse();
			} else {
				$this ->response['ret'] = 0;
				$this ->response['msg'] = "Incorrect password";
				$this ->endResponse();
			}
		} else {
			$this ->response['ret'] = 0;
			$this ->response['msg'] = "Email not exists";
			$this ->endResponse();
		}
	}
	
	// 结束修改发送请求
	private function endResponse() {
		header('Content-Type:text/json');
		echo json_encode($this ->response);
		exit();
	}
}
?>