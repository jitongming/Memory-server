<?php
class memory extends DataBaseModel {
	//���ڲ�ѯָ��ʱ��֮�ڵĴӵڼ�����ʼ����������¼
	public function search($starttime, $endtime, $from, $count, $userid) {
		global $con;
		if ($starttime == "") {
			$query = sprintf("SELECT * FROM %s WHERE User_id = %s AND add_datetime <= '%s' ORDER BY add_datetime DESC LIMIT %d OFFSET %d", 
				$this ->_dbName, $userid, $endtime, $count, $from);
		} else if ($endtime == ""){
			$query = sprintf("SELECT * FROM %s WHERE User_id = %s AND add_datetime >= '%s' ORDER BY add_datetime DESC LIMIT %d OFFSET %d ", 
				$this ->_dbName, $userid, $starttime, $count, $from);
		} else {
			$query = sprintf("SELECT * FROM %s WHERE User_id = %s AND add_datetime >= '%s' and add_datetime <= '%s' ORDER BY add_datetime DESC LIMIT %d OFFSET %d ",
				$this ->_dbName, $userid ,$starttime, $endtime, $count, $from);
		}
		
		$result = mysqli_query($con, $query);
		
		if ($result == FALSE) {
			return 'Failed!';
		}
		
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($this ->_data, $row);
		}
		return 'Success!';
	}
}
?>