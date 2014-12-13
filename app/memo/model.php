<?php
/**
* 数据库模型
*/
include("database.php");

class DatabaseModel {
	private $_data = array();
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
		foreach ($_data as $key => $value) {
			array_push($fields, $key);
			array_push($values, $value);
		}
		$fieldsString = implode(",", $fields);
		$valuesString = implode(",", $values);
		$query = sprintf("INSERT INTO %s { %s } VALUES { %s }", $_dbName, $fieldsString, $valuesString);
		
		$result = mysqli_query($con, $query);
		if ($row = mysqli_fetch_assoc($result)){
			return $row;
		} else {
			return "Faild!";
		}
		
	}
	
	/**
	*	删除数据方法delete
	*	参数：列名，列值
	*/
	public function delete($rowkey, $rowvalue) {
		global $con;
		$query = sprintf("DELETE FROM %s WHERE %s = %s", $_dbName, $rowkey, $rowvalue);
		return mysqli_query($con, $query);
	}
	
	/**
	*	修改数据方法update
	*	参数：用作更新条件的id字段名和值
	*/
	public function update($idfield, $idvalue) {
		global $con;
		$update = array();
		foreach ($_data as $key => $value) {
			$string = $key . '=' . $value;
			array_push($update, $string);
		}
		$updateString = implode(",", $update);
		$query = sprintf("UPDATE %s SET %s WHERE %s = %s", $_dbName, $updateString, $idfield, $idvalue);
		return mysqli_query($con, $query);
	}
	
	/**
	*	获取数据方法fetch
	*	参数：列名，列值
	*/
	public function fetch($rowkey, $rowvalue) {
		global $con;
		$query = sprintf("SELECT * from %s WHERE %s = %s", $this ->_dbName, $rowkey, $rowvalue);
		$result = mysqli_query($con, $query);
		if ($row = mysqli_fetch_assoc($result)) {
			return $row;
		} else {
			return "No result";
		}
	}
	
	
}
?>