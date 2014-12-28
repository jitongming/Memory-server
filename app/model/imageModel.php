<?php
class image extends DataBaseModel {
	public function fetchAllByMemoryId($mid) {
		global $con;
		$query = sprintf("SELECT Img_id from %s WHERE M_id = %d", $this ->_dbName, $mid);
		
		$result = mysqli_query();
		
	}
}
?>