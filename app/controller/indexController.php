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
			
			$memo = $this ->model('memory', 'memory');
			$memo ->search('', date("Y-m-d h:M:s"), 0, 10, $user ->_data['User_id']);
			//print_r($memo ->_data);
			
			//$memo = $this ->model('memory', 'memory');
			
			$img = $this ->model('image','imginfo');
			$mp = $this ->model('mp','mp');
			$partner = $this ->model('partner','partner');
			
			$memorypoint = '';
			
			foreach ($memo ->_data as $memory) {
				$this ->assign('add_datetime', $memory['add_datetime']);
				$this ->assign('M_title', $memory['M_title']);
				$this ->assign('M_content', $memory['M_content']);
				$this ->assign('edit_datetime', $memory['edit_datetime']);
				$this ->assign('location',$memory['location']);
	
				$img ->fetch('M_id', $memory['M_id']);
				$this ->assign('img_url',$img ->_data['img_url']);
			
				$mp ->fetch('M_id', $memory['M_id']);
				$partner ->fetch('P_id', $mp ->_data['P_id']);
				$this ->assign('Pname',$partner ->_data['Pname']);
				$memorypoint .= $this ->render('memory-point', 'No');
			}
			
			$this ->assign('memory-point', $memorypoint);
			
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
		$memo ->search("2014-12-20 11:15:16", "", 0, 10, 1);
		print_r($memo ->_data);
	}
}
?>