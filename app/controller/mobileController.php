<?php
class mobileController extends Controller {
	
	private $response = Array(
		'ret' => 0,
		'msg' => '',
		'data' => Array()
	);
	
	private $inputArray;
	
	public function __construct() {
		
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
	*		"ret": 1,
	*		"msg": "ok",
	*		"data": {
	*			"register":"success",
	*			"session_id":"kappn7iahhf5316nnhg1ejval3"
	*		}
	*	}
	*/
	public function register() {
		$inputArray = $this ->inputArray;
		$user = $this ->model('user', 'user');
		if ($user -> fetch('email', $inputArray['email']) == "No result") {
			$user ->set('email', $inputArray['email']);
			$user ->set('password', $inputArray['pwd']);
			$user ->set('status', 1);
			
			if($user ->add() == "Failed!") {
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
			if($conf ->add() == "Failed!") {
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
			$this ->response['msg'] = "This email existed.";
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
	*		"ret": 1,
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
				$_SESSION['uid'] = $conf ->_data['User_id'];
				
				$this ->response['ret'] = 1;
				$this ->response['msg'] = "OK";
				$this ->response['data']['id'] = $user ->_data['User_id'];
				$this ->response['data']['nickname'] = $conf ->_data['nickname'];
				$this ->response['data']['session_id'] = session_id();
				//$this ->response['data']
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
	/**
	*
	*/
	public function logout() {
		if ($_SESSION['login'] == TRUE) {
			$_SESSION['login'] = FALSE;
			$_SESSION['uid'] = 0;
		}
	}
	
	/** 查询memo列表，分页获取
	*	提交数据格式：
	*	{
	*		"session_id": "sdfdsfsdafsa",
	*		"start_time": "2014-11-30 00:00:00",
	*		"end_time": "2014-12-31 00:00:00",
	*		"start_num": 0,
	*		"num": 1
	*	}
	*	返回数据格式：
	*	{
	*		"ret": 1,
	*		"msg": "ok",
	*		"data": {
	*			"memory":[{
	*				"title":"party",
	*				"location":"ucas",
	*				"add_datetime":"2014-12-12 09:19:45",
	*				"edit_datetime":"2014-12-12 09:19:45",
	*				"picture":[
	*					"123123",
	*					"123241"
	*				],
	*				"content":"nice party"
	*			},
	*			{
	*				"title":"party",
	*				"location":"ucas",
	*				"datetime":"2014-12-12 09:19",
	*				"picture":[
	*					"123123",
	*					"34324"
	*				]
	*			}]
	*		}
	*
	*/
	public function memories() {
		$inputArray = $this ->inputArray;
		//print_r($inputArray);
		$this ->checkLogin();
		$memo = $this ->model('memory', 'memory');
		$starttime = isset($inputArray['start_time']) ? $inputArray['start_time'] : "";
		$endtime = isset($inputArray['end_time']) ? $inputArray['end_time'] : "";
		$from = $inputArray['start_num'];
		$num = $inputArray['num'];
		$user_id = $_SESSION['uid'];
		$memo ->search($starttime, $endtime, $from, $num, $user_id);
		if (count($memo ->_data) == 0) {
			$this ->response['ret'] = 0;
			$this ->response['msg'] = "No result";
			$this ->endResponse();
		}
		
		$img = $this ->model('image', 'imginfo');
		$mp = $this ->model('mp', 'mp');
		$partner = $this ->model('partner','partner');
		
		$this ->response['data']['memory'] = array();
		//$this ->
		foreach ($memo ->_data as $memory) {
			$img ->fetch('M_id', $memory['M_id']);
			$mp ->fetch('M_id', $memory['M_id']);
			//$partner ->fetch('P_id', $mp ->_data['P_id']);
			//print_r($partner ->_data);
			$s_memory['id'] = $memory['M_id'];
			$s_memory['title'] = $memory['M_title'];
			$s_memory['location'] = $memory['location'];
			//$s_memory['coordinate'] = $memory['coordinate'];
			$s_memory['datetime'] = $memory['add_datetime'];
			$s_memory['picture'] = $img ->_data['img_url'];
			$s_memory['content'] = $memory['M_content'];
			//$s_memory['partner'] = $partner ->_data['Pname'];
			//$s_memory['partner'] = $parter ->_data['P_id'];
			array_push($this ->response['data']['memory'] ,$s_memory);
		}
		$this ->response['ret'] = 1;
		$this ->response['msg'] = "OK";
		//print_r($this ->response);
		$this ->endResponse();
	}
	
	/** 
	*	提交数据格式：
	* 	{
	*		"session_id": "sdfdsfsdafsa",
	*		"title": "party",
	*		"location": "",
	*		"datetime": "2014-12-31 09:24:25",
	*		"content":"tomorrow",
	*		"people": [
	*			"name":"jitongming",
	*			"name":"luxiaohong"
	*		],
	*		"picture":[
	*			"id":"123123",
	*			"id":"121234"
	*		]			
	*	}
	* 	返回数据格式：
	* 	{
	*		"ret": 1,
	*		"msg": "ok",
	*		"data": {
	*			"id": "1"
	*		}
	*	}
	*
	*
	*/
	public function memory_add() {
		$inputArray = $this ->inputArray;
		$this ->checkLogin();

		$memory = $this->model('memory','memory');
		
		$memory ->set('M_title',$inputArray['title']);
		$memory ->set('M_content',$inputArray['content']);;
		$memory ->set('location',$inputArray['location']);
		$memory ->set('add_datetime',$inputArray['datetime']);
		$memory ->set('edit_datetime',$inputArray['datetime']);
		$memory ->set('User_id', $_SESSION['uid']);
		
		$memory ->add();
		
		$memory ->fetch('add_datetime', $inputArray['datetime']);
		$mp = $this ->model('mp', 'mp');
		$partner = $this ->model('partner', 'partner');
		$partner ->fetch('Pname', $inputArray['people']);
		
		$mp ->set('P_id', $partner ->_data['P_id']);
		$mp ->set('M_id', $memory ->_data['M_id']);
		$mp ->add();
		
		$img = $this ->model('image', 'imginfo');
		if (isset($inputArray['picture'])) {
			$img ->set('img_url', 'default.jpg');
		} else {
			$img ->set('img_url', $input['picture']);
		}
		$img ->set('category', 1);
		$img ->set('User_id', $_SESSION['uid']);
		$img ->set('M_id', $memory ->_data['M_id']);
		$img ->add();
		
		$this ->response['ret'] = 1;
		$this ->response['msg'] = "OK";
		$this ->response['data']['id'] = $memory ->_data['M_id'];
		$this ->endResponse();
	} 
	/**
	*	提交数据格式：
	*	{
	*		"session_id":"sdfdsfsdafsa"
	*	}
	*	返回数据格式：
	* 	{
	*		"ret": 1,
	*		"msg": "ok",
	*		"data": {
	*			"email": "guan@163.com",
	*			"nickname":"guanjichang",
	*			"picture":"default.jpg",
	*			"password":"123456789"
	*		}
	*	}
	*
	*/
	public function user_info() {
		$inputArray = $this ->inputArray;
		$this ->checkLogin();
		
		$user = $this ->model('user', 'user');
		$conf = $this ->model('conf', 'conf');
		$user ->fetch('User_id', $_SESSION['uid']);
		$conf ->fetch('User_id', $_SESSION['uid']);
				
		//print_r($user ->_data);
		//print_r($conf ->_data);
		$this ->response['ret'] = 1;
		$this ->response['msg'] = "OK";
		$this ->response['data']['email'] = $user ->_data['email'];
		$this ->response['data']['nickname'] = $conf ->_data['nickname'];
		$this ->response['data']['picture'] = $conf ->_data['background'];
		$this ->response['data']['password'] = $user ->_data['password'];
		
		$this ->endResponse();
	}
	/**
	*	提交数据格式：
	*	{
	*		"password":"987654321",
	*		"conf_title":"test",
	*		"nickname":"wolegequ",
	*		"description":"what do you need?",
	*		"picture":"yukiyuki.jpg"
	*	}
	*	返回数据格式：
	* 	{
	*		"ret": 1,
	*		"msg": "ok",
	*		"data": {
	*			"update":"success"
	*		}
	*	}
	*
	*/
	public function user_update() {
		$inputArray = $this ->inputArray;
		$this ->checkLogin();
		
		$user = $this ->model('user', 'user');
		$conf = $this ->model('conf', 'conf');
		$user ->fetch('User_id', $_SESSION['uid']);
		$conf ->fetch('User_id', $_SESSION['uid']);
	
		$user ->set('password', $inputArray['password']);
		$conf ->set('conf_title', $inputArray['conf_title']);
		$conf ->set('nickname', $inputArray['nickname']);
		$conf ->set('description', $inputArray['description']);
		$conf ->set('background', $inputArray['picture']);
		$user ->update('User_id', $_SESSION['uid']);
		$conf ->update('User_id', $_SESSION['uid']);
		print_r($user ->_data);
		print_r($conf ->_data);
		
		$this ->response['ret'] = 1;
		$this ->response['msg'] = 'OK';
		$this ->response['data']['update'] = 'success';
		
		$this ->endResponse();
	}
	// 结束修改发送请求
	private function endResponse() {
		header('Content-Type:text/json');
		echo json_encode($this ->response);
		exit();
	}
	// 检查登录情况
	private function checkLogin() {
		if (!(isset($_SESSION['login']) && $_SESSION['login'] == TRUE)) {
			$this ->response['ret'] = 0;
			$this ->response['msg'] = "Auth Failed";
			$this ->endResponse();
		} 
	}
}
?> 