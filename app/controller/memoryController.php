<?php
class memoryController extends Controller {
	//memory index
	
	public function index(){
		$memory = $this->model('memory','memory');
		$location = $memory->fetch('location','12');
		echo "this is index page";
		//var_dump($memory);
		//print_r($memory->_data);
		//var_dump($location);
		//echo gettype($memory);
	}

	public function publish(){
	//����Ҫ�ж��ύ��session
		date_default_timezone_set("Asia/Shanghai");
		if(!($this ->checkLogin() == TRUE)) {  
			echo "You don't have logged in or may be you have not submit.";
			//echo $_POST["submit"];
			exit();
		} else {
			if(($_POST['title'] == '')||($_POST['content'] == '')||($_POST['location'] == '')) {
			//����ύ���ֶδ��ڿ�ֵ
				echo "The commit is not...";
				exit();
			} else {
				$memory = $this->model('memory','memory');
				$memory ->set('M_title',$_POST['title']);
				$memory ->set('M_content',$_POST['content']);
				$memory ->set('location',$_POST['location']);
				$memory ->set('coordinate',$_POST['location']);
				$memory ->set('add_datetime',date('Y-m-d H:i:s',time()));
				$memory ->set('edit_datetime',date('Y-m-d H:i:s',time()));
				$memory ->set('User_id', $_SESSION['uid']);
				echo $memory ->add();
				$memory ->fetch('add_datetime', date('Y-m-d H:i:s', time()));
				$mp = $this ->model('mp', 'mp');
				$mp ->set('M_id', $memory ->_data['M_id']);
				$mp ->set('P_id', $_POST['partner']);
				//print_r($memory);
				echo $mp ->add();
			}
		}
	}
	
	public function edit() {
		echo file_get_contents("app/view/edit.html");
	}

	public function update(){
		if(!($this ->checkLogin() == TRUE))	{
			echo "You don't have logged in or may be you have not submit.";
			exit();
		} else {
			$memory = $this ->model('memory', 'memory');
			//�����������Ƿ������$_POST['M_id']������������������
			$memory ->fetch('M_id', $_POST['M_id']);
			$memory ->set('M_title',$_POST['title']);
			$memory ->set('M_content',$_POST['content']);
			$memory ->set('location',$_POST['location']);
			$memory ->set('coordinate',$_POST['location']);
			$memory ->set('edit_datetime',date('Y-m-d H:i:s',time()));
			echo $memory ->update('M_id',$_POST['M_id']);
			echo "update success";
		}
	}
	
	public function edittab() {
		
	}

	public function destroy(){
		if(!($this ->checkLogin() == TRUE))
		{  
			echo "You don't have logged in may be you have not submit.";
			exit(); 
		} else {
			$memory = $this ->model('memory', 'memory');
			$memory ->delete('M_id', $_POST['M_id']);
			echo "delete success";
		}
	}	

	public function search(){
		$memory = $this ->model('memory', 'memory');


	}

	
	/***
	*	�������
	*/
	public function checkLogin(){
		if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE){
			return true;
		} else {
			return false;
		}
	}	
}

?>
