<?php
/**
* 数据库模型
*/
include("database.php");

class DatabaseModel {
	public $_data = array();
	private $_dbName = "";
	
	
	public function __construct($dbname) {
		$this ->_dbName = $dbname;
	}
	
	/**
	*	增加数据方法add
	*	参数：无
	*/
	public function add() {
		global $con;
		$fields = array();
		$values = array();
		foreach ($this ->_data as $key => $value) {
			if (is_string($value)) {
				$value = "'" . $value . "'";
			}
			array_push($fields, $key);
			array_push($values, $value);
		}
		
		$fieldsString = implode(",", $fields);
		$valuesString = implode(",", $values);
		$query = sprintf("INSERT INTO %s ( %s ) VALUES ( %s )", $this ->_dbName, $fieldsString, $valuesString);
		//print_r($query);
		$result = mysqli_query($con, $query);
		
		if ($result == TRUE){
			return "Success!";
		} else {
			return "Failed!";
		}
		
	}
	
	/**
	*	删除数据方法delete
	*	参数：列名，列值
	*/
	public function delete($rowkey, $rowvalue) {
		global $con;
		
		$query = sprintf("DELETE FROM %s WHERE %s = %s", $this ->_dbName, $rowkey, $rowvalue);
		$result = mysqli_query($con, $query);
		
		if ($result == TRUE){
			return "Success!";
		} else {
			return "Failed!";
		}
	}
	
	/**
	*	修改数据方法update
	*	参数：用作更新条件的id字段名和值
	*/
	public function update($idfield, $idvalue) {
		global $con;
		$update = array();
		foreach ($this ->_data as $key => $value) {
			if (is_string($value)) {
				$value = "'" . $value . "'";
			}
			$string = $key . '=' . $value;
			array_push($update, $string);
		}
		$updateString = implode(",", $update);
		
		$query = sprintf("UPDATE %s SET %s WHERE %s = %s", $this ->_dbName, $updateString, $idfield, $idvalue);
		print_r($query);
		$result = mysqli_query($con, $query);
		
		if ($result == TRUE){
			return "Success!";
		} else {
			return "Failed!";
		}
	}
	
	/**
	*	获取数据方法fetch
	*	参数：列名，列值
	*/
	public function fetch($rowkey, $rowvalue) {
		global $con;
		
		$query = sprintf("SELECT * from %s WHERE %s = %s", $this ->_dbName, $rowkey, "'" . $rowvalue . "'");
		$result = mysqli_query($con, $query);
		
		if ($result == FALSE){
			return "Failed!";
		} 
		
		if ($row = mysqli_fetch_assoc($result)) {
			$this ->_data = $row;
			return "Success!";
		} else {
			return "No result";
		}
	}
	/**
	*	修改数据方法set
	*	参数：列名，列值
	*/
	public function set($rowkey, $rowvalue) {
		$this ->_data[$rowkey] = $rowvalue;
	}
}
?>