<?php
	defined('APP_PATH') OR exit('No direct script access allowed');
	class Database {
		public $base_path;
		
		public function DBConnection() {
			$root = ['libraries'];
			$path = str_replace('\\', '/', __DIR__);
			$path = explode('/', $path);

			$path = array_values(array_filter(array_diff($path, $root)));

			foreach ($path as $key) {
				$this->base_path.= $key.'/';
			}

			if(APP_URL != "") {
                $this->base_path = "";
            }

			require($this->base_path.'config/database.php');
			$database = $database['default'];

			$con = mysqli_connect($database['hostname'], $database['username'], $database['password'], $database['database']);
			if ($con == true) {
				return $con;
			}
			else {
				return die(mysqli_connect_error());
			}
		}
	}
?>