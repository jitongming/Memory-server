<?php
//����¼״̬
class LoginCheck{
public function checkLogin(){
 if(isset($_SESSION['login']) && $_SESSION['login']==TRUE){
 return true;
 
 }
 else{
 
 return false;
 }
exit();
}
}
$checkLogin=new LoginCheck();
$checkLogin=$checkLogin->checkLogin();


class memoryController extends Controller{
	//memory index
public function index(){
$memory=$this->model('memory','memory');
$location=$memory->fetch('location','12');
echo "this is index page";
//var_dump($memory);
//print_r($memory->_data);
//var_dump($location);
//echo gettype($memory);
}

public function publish(){
//����Ҫ�ж��ύ��session
   
   if(!(isset($_POST["submit"])&&($checkLogin==TRUE)))
   {  echo "You don't have logged in or may be you have not submit";
     exit();
	 } 
    else{
	
	
	if(($_POST['title']=='')||($_POST['content']=='')||($_POST['location']==''))
	{
	//����ύ���ֶδ��ڿ�ֵ
	echo "��д��ȫ";
	exit();
	}
	else{
	//����ʱ��##########################�������Ҫ�ŵ������ļ���
	date_default_timezone_set('PRC');
    $memory=$this->model('memory','memory');
	$memory ->set('title',$_POST['title']);
	$memory ->set('content',$_POST['content']);
	$memory ->set('location',$_POST['location']);
	$memory ->set('add_datetime',date('Y-m-d H:i:s',time()));
	$memory ->set('edit_datetime',date('Y-m-d H:i:s',time()));
	echo $memory ->add();
	echo "publish success";
      }
	  }
}

public function update(){
 if(!(isset($_POST["submit"])&&($checkLogin==TRUE)))
   {  echo "�����δ��½����û���ύmay be you have not submit";
     exit();
	 } 
    else{
		//����ʱ��##########################�������Ҫ�ŵ������ļ���
     	date_default_timezone_set('PRC');
        $memory = $this ->model('memory', 'memory');
		//�����������Ƿ������$_POST['M_id']������������������
		$memory  ->fetch('M_id', $_POST['M_id']);
		$memory ->set('title',$_POST['title']);
		$memory ->set('content',$_POST['content']);
		$memory ->set('location',$_POST['location']);
		$memory ->set('edit_datetime',date('Y-m-d H:i:s',time()));
		echo $memory ->update('M_id',$_POST['M_id']);
		echo "update success";
     }

}

public function destroy(){
 if(!(isset($_POST["submit"])&&($checkLogin==TRUE)))
   {  echo "�����δ��½����û���ύmay be you have not submit";
     exit();
	 } 
    else{
		$memory = $this ->model('memory', 'memory');
		$memory->delete('M_id', $_POST['M_id']);
		echo "delete success";
		}
}

public function search(){
$memory = $this ->model('memory', 'memory');


}



}
?>
