<?php
	require("database.php");
	
	class QueryBuilder extends Database {
		public $db;

		public function __construct() {
			$this->db = $this->DBConnection();
		}

		//Custom Query Builder
		public function custom_query($query)
		{
			return $result = $this->db->query($query);
		}

		//Insert Data Into Database
		public function set($table, $data)
		{
			$key = array_keys($data);
			$value = ""; $column = ""; $i = 0;
			
			foreach($data as $row) {
				$i++;
				if(sizeof($data) > $i) {	
					$value.= "'$row',";
					$column.= $key[$i-1].",";
				}
				else {
					$value.= "'$row'";
					$column.= $key[$i-1];
				}
			}
			
			$query = "insert into ".$table." ($column) values ($value)";
			
			if ($this->db->query($query) == true) {
				return true;
			}
			else {
				return false;
			}
		}
		
		//Delete Data From Database
		public function delete($table, $data)
		{
			$cnd = ""; $i = 0;
			$key = array_keys($data);
			
			foreach($data as $row) {
				$i++;
				if(sizeof($data) > $i) {	
					$cnd.= $key[$i-1]." = "."'$row' and ";
					
				}
				else {
					$cnd.= $key[$i-1]." = "."'$row'";
				}
			}
			
			$query = "delete from ".$table." where ".$cnd."";
			
			if ($this->db->query($query) == true) {
				return true;
			}
			else {
				return false;
			}
		}

		//Delete All Data From Database
		public function delete_all($table)
		{
			$query = "TRUNCATE TABLE ".$table."";
			
			if ($this->db->query($query) == true) {
				return true;
			}
			else {
				return false;
			}
		}

		//Update Data Into Database
		public function edit($table, $data, $condition)
		{
			$key1 = array_keys($data);
			$key2 = array_keys($condition);
			$field = ""; $cnd = ""; $i = 0; $j = 0;
			
			foreach($data as $row) {
				$i++;
				if(sizeof($data) > $i) {	
					$field.= $key1[$i-1]." = "."'$row', ";
					
				}
				else {
					$field.= $key1[$i-1]." = "."'$row'";
				}
			}
			
			foreach($condition as $row) {
				$j++;
				if(sizeof($condition) > $j) {	
					$cnd.= $key2[$j-1]." = "."'$row' and ";
					
				}
				else {
					$cnd.= $key2[$j-1]." = "."'$row'";
				}
			}
			
			$query = "update ".$table." set ".$field." where ".$cnd."";
			
			if ($this->db->query($query) == true) {
				return true;
			}
			else {
				return false;
			}
		}
		
		//Fetch Data From Database
		public function get($table)
		{
			$query = "select * from ".$table."";
			return $result = $this->db->query($query);
		}
		
		//Fetch Data From Database With Condition
		public function get_where($table, $data)
		{
			$cnd = ""; $i = 0;
			$key = array_keys($data);
			
			foreach($data as $row) {
				$i++;
				if(sizeof($data) > $i) {	
					$cnd.= $key[$i-1]." = "."'$row' and ";
					
				}
				else {
					$cnd.= $key[$i-1]." = "."'$row'";
				}
			}
			
			$query = "select * from ".$table." where ".$cnd."";
			return $result = $this->db->query($query);
		}
		
		//Fetch Limited Data From Database
		public function get_limit($table, $limit)
		{
			$query = "select * from ".$table." limit ".$limit."";
			return $result = $this->db->query($query);
		}
        
        //Fetch Limited Data From Database With Condition
		public function get_limit_where($table, $data, $limit)
		{
			$cnd = ""; $i = 0;
			$key = array_keys($data);
				
			foreach($data as $row) {
				$i++;
				if(sizeof($data) > $i) {	
					$cnd.= $key[$i-1]." = "."'$row' and ";	
				}
				else {
					$cnd.= $key[$i-1]." = "."'$row'";
				}
			}
			$query = "select * from ".$table." where ".$cnd." limit ".$limit."";
			return $result = $this->db->query($query);
		}
        
		//Fetch Data From Database With Order
		public function get_order($table, $col, $order)
		{
			$query = "select * from ".$table." order by ".$col." ".$order."";
			return $result = $this->db->query($query);
		}
        
		//Fetch Data From Database With Condition And Order
		public function get_order_where($table, $data, $col, $order)
		{
			$cnd = ""; $i = 0;
			$key = array_keys($data);
				
			foreach($data as $row) {
				$i++;
				if(sizeof($data) > $i) {	
					$cnd.= $key[$i-1]." = "."'$row' and ";	
				}
				else {
					$cnd.= $key[$i-1]." = "."'$row'";
				}
			}
			$query = "select * from ".$table." where ".$cnd." order by ".$col." ".$order."";
			return $result = $this->db->query($query);
		}
		
		//Search Data Into Database
		public function like($table, $data)
		{
			$cnd = ""; $i = 0;
			$key = array_keys($data);
			
			foreach($data as $row) {
				$i++;
				if(sizeof($data) > $i) {
					$cnd.= $key[$i-1]." like "."'$row%' or ";
				}
				else {
					$cnd.= $key[$i-1]." like "."'$row%'";
				}
			}
			
			$query = "select * from ".$table." where ".$cnd."";
			return $result = $this->db->query($query);
		}

		//Result Of Database Query
		public function result_array($object)
		{
			$result = array();
			
			while ($row = mysqli_fetch_array($object)) {
				$result[] = $row;
			}
			return $result;
		}
		
		public function row_array($object)
		{
			return $result[] = mysqli_fetch_assoc($object);
		}
		
		public function num_rows($object)
		{
			return $result = mysqli_num_rows($object);
		}
	}
?>