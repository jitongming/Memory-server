<?php
class memory extends DataBaseModel {
	//用于查询指定时间之内的从第几条开始的若干条记录
	public function search($starttime, $endtime, $from, $count) {
		global $con;
		if ($starttime == "") {
			$query = sprintf("SELECT * FROM %s WHERE add_datetime <= '%s' LIMIT %d OFFSET %d", 
				$this ->_dbName, $endtime, $count, $from);
		} else if ($endtime == ""){
			$query = sprintf("SELECT * FROM %s WHERE add_datetime >= '%s' LIMIT %d OFFSET %d", 
				$this ->_dbName, $starttime, $count, $from);
		} else {
			$query = sprintf("SELECT * FROM %s WHERE add_datetime >= '%s' and add_datetime <= '%s' LIMIT %d OFFSET %d",
				$this ->_dbName, $starttime, $endtime, $count, $from);
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