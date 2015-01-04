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
	//还需要判断提交和session
		date_default_timezone_set("Asia/Shanghai");
		if(!($this ->checkLogin() == TRUE)) {  
			echo "You don't have logged in or may be you have not submit.";
			//echo $_POST["submit"];
			exit();
		} else {
			if(($_POST['title'] == '')||($_POST['content'] == '')||($_POST['location'] == '')) {
			//如果提交的字段存在空值
				echo "The commit is not...";
				exit();
			} else {
				print_r($_FILES);
				if ((($_FILES["file"]["type"] == "image/png")
					|| ($_FILES["file"]["type"] == "image/jpeg")
					|| ($_FILES["file"]["type"] == "image/gif"))
					&& ($_FILES["file"]["size"] < 200000))
				{
					if ($_FILES["file"]["error"] > 0)
					{
						echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
					}
					else
					{
						echo "Upload: " . $_FILES["file"]["name"] . "<br />";
						echo "Type: " . $_FILES["file"]["type"] . "<br />";
						echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
						echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
						if (file_exists("E:\\wamp\\www\\memory\\public\\img\\" . $_FILES["file"]["name"]))
						{
							echo $_FILES["file"]["name"] . " already exists. ";
						}
						else
						{
							if (move_uploaded_file($_FILES["file"]["tmp_name"], "E:\\wamp\\www\\memory\\public\\img\\" . $_FILES["file"]["name"])){
								echo "Stored in: " . "E:\\wamp\\www\\memory\\public\\img\\" . $_FILES["file"]["name"] . "<br />";
							} else {
								echo "Move failed...";
							}
						} 
					}
				}
				else
				{
					echo "Invalid file";
				}
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
				echo $mp ->add();
				$img = $this ->model('image','imginfo');
				$img ->set('M_id', $memory ->_data['M_id']);
				$img ->set('img_url', $_FILES['file']['name']);
				$img ->set('category','1');
				$img ->set('User_id',$_SESSION['uid']);
				echo $img ->add();
				//header('Location: /memory/');
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
			//？？？？？是否有这个$_POST['M_id']？？？？？？？？？
			$memory ->fetch('M_id',$_POST['M_id']);
			$memory ->set('M_title',$_POST['title']);
			$memory ->set('M_content',$_POST['content']);
			$memory ->set('location',$_POST['location']);
			$memory ->set('coordinate',$_POST['location']);
			$memory ->set('edit_datetime',date('Y-m-d H:i:s',time()));
			echo $memory ->update('M_id',$_POST['M_id']);
			$mp =$this ->model('mp','mp');
			$mp ->fetch('M_id',$_POST['M_id']);
			$mp ->set('P_id',$_POST['partner']);
			echo $mp ->update('M_id',$_POST['M_id']);
			print_r($memory);
			//header('Location: /memory/');
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
	*	检查输入
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
