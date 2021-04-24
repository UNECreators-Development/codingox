<?php
require("database.php");

class QueryBuilder extends Database
{
	public $db;

	public function __construct()
	{
		$this->db = $this->DBConnection();
	}

	function __call($method, $param)
	{
		//Custom Query Builder
		if ($method == "query" || $method == "Query") {
			return $result = $this->db->query($param[0]);
		}

		//Insert Data Into Table
		if ($method == "insert" || $method == "set" || $method == "add") {
			$i = 0;
			$value = "";
			$column = "";
			$key = array_keys($param[1]);

			foreach ($param[1] as $row) {
				$i++;
				if (sizeof($param[1]) > $i) {
					$value .= "'$row',";
					$column .= $key[$i - 1] . ",";
				} else {
					$value .= "'$row'";
					$column .= $key[$i - 1];
				}
			}

			$query = "insert into " . $param[0] . " ($column) values ($value)";

			return $this->db->query($query);
		}

		//Delete Data From Table
		if ($method == "delete" || $method == "remove") {
			$i = 0;
			$cnd = "";
			$key = array_keys($param[1]);

			foreach ($param[1] as $row) {
				$i++;
				if (sizeof($param[1]) > $i) {
					$cnd .= $key[$i - 1] . " = " . "'$row' and ";
				} else {
					$cnd .= $key[$i - 1] . " = " . "'$row'";
				}
			}

			$query = "delete from " . $param[0] . " where " . $cnd . "";
			return $this->db->query($query);
		}

		//Delete All Data From Table
		if ($method == "truncate" || $method == "delete_all" || $method == "remove_all") {
			$query = "TRUNCATE TABLE " . $param[0] . "";

			return $this->db->query($query);
		}

		//Update Data Into Table
		if ($method == "update" || $method == "edit" || $method == "modify") {
			$i = 0;
			$j = 0;
			$cnd = "";
			$field = "";
			$key1 = array_keys($param[1]);
			$key2 = array_keys($param[2]);

			foreach ($param[1] as $row) {
				$i++;
				if (sizeof($param[1]) > $i) {
					$field .= $key1[$i - 1] . " = " . "'$row', ";
				} else {
					$field .= $key1[$i - 1] . " = " . "'$row'";
				}
			}

			foreach ($param[2] as $row) {
				$j++;
				if (sizeof($param[2]) > $j) {
					$cnd .= $key2[$j - 1] . " = " . "'$row' and ";
				} else {
					$cnd .= $key2[$j - 1] . " = " . "'$row'";
				}
			}

			$query = "update " . $param[0] . " set " . $field . " where " . $cnd . "";

			return $this->db->query($query);
		}

		//Fetch Data From Table
		if ($method == "get" || $method == "get_where" || $method == "fetch" || $method == "select") {
			switch (count($param)) {
				case 1:
					$query = "select * from " . $param[0] . "";
					return $result = $this->db->query($query);
				case 2:
					$i = 0;
					$cnd = "";
					$key = array_keys($param[1]);

					foreach ($param[1] as $row) {
						$i++;
						if (sizeof($param[1]) > $i) {
							$cnd .= $key[$i - 1] . " = " . "'$row' and ";
						} else {
							$cnd .= $key[$i - 1] . " = " . "'$row'";
						}
					}
					$query = "select * from " . $param[0] . " where " . $cnd . "";
					return $result = $this->db->query($query);
			}
		}

		//Fetch Limited Data From Table
		if ($method == "limit") {
			switch (count($param)) {
				case 1:
					$query = "select * from " . $param[0] . " limit 10";
					return $result = $this->db->query($query);
				case 2:
					$query = "select * from " . $param[0] . " limit " . $param[1] . "";
					return $result = $this->db->query($query);
				case 3:
					$i = 0;
					$cnd = "";
					$key = array_keys($param[1]);

					foreach ($param[1] as $row) {
						$i++;
						if (sizeof($param[1]) > $i) {
							$cnd .= $key[$i - 1] . " = " . "'$row' and ";
						} else {
							$cnd .= $key[$i - 1] . " = " . "'$row'";
						}
					}
					$query = "select * from " . $param[0] . " where " . $cnd . " limit " . $param[1] . "";
					return $result = $this->db->query($query);
			}
		}

		//Fetch Similar Data From Table
		if ($method == "search" || $method == "find" || $method == "like") {
			$i = 0;
			$cnd = "";
			$key = array_keys($param[1]);

			foreach ($param[1] as $row) {
				$i++;
				if (sizeof($param[1]) > $i) {
					$cnd .= $key[$i - 1] . " like " . "'$row%' or ";
				} else {
					$cnd .= $key[$i - 1] . " like " . "'$row%'";
				}
			}

			$query = "select * from " . $param[0] . " where " . $cnd . "";
			return $result = $this->db->query($query);
		}
	}
}
