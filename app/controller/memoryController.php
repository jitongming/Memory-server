<?php
class memoryController extends Controller{

	//memory index
public function index(){
$memory=$this->model('memory','memory');
$location=$memory->fetch('location','12');
//var_dump($memory);
//print_r($memory->_data);
//var_dump($location);
//echo gettype($memory);
}

public function publish(){
$memory=$this->model('memory','memory');
	$memory ->set('location', '13');
		echo $memory ->add();

}

public function update(){
$memory = $this ->model('memory', 'memory');
		$memory  ->fetch('M_id', 1);
		$memory ->set('location', '123456789');
		echo $memory ->update('M_id', 1);

}

public function destroy(){
$memory = $this ->model('memory', 'memory');
$memory->delete('M_id',2);
echo "delete success";
}

public function search(){
$memory = $this ->model('memory', 'memory');


}



}
?>