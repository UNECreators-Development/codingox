<?php
defined('APP_PATH') or exit('No direct script access allowed');

if (!function_exists('model')) {
	/**
	 * Generate Model
	 * @param	string 	$table	    (Table name)
	 * @param	array 	$operation 	(Database operation)
	 * @param	string 	$modelPath	(Model dir path)
	 * @return	bool
	 **/
	function model($table, $operation, $modelPath)
	{
		$function = NULL;
		$data  = '$data';
		$where = '$where';
		$query = '$query';

		$modelPath = str_replace('\\', '/', $modelPath);
		$modelPath = explode('/', $modelPath);
		unset($modelPath[array_key_first($modelPath)]);

		$modelPath = array_values($modelPath);
		$modelPath = implode('/', $modelPath) . DIRECTORY_SEPARATOR;

		if (!file_exists(path() . model_path . DIRECTORY_SEPARATOR . $modelPath)) {
			mkdir(path() . model_path . DIRECTORY_SEPARATOR . $modelPath);
		}

		$db = 'return $this->db->query' . "($query)->execute()" . ';';
		$function .= "\n\tpublic function query($query)\n\t{\n\t\t" . $db . "\n\t}\n\t";

		foreach ($operation as $key => $value) {
			if ($value == 'insert') {
				$db = 'return $this->db->insert' . '($this->table, $data)->execute();';
				$function .= "\n\tpublic function " . $value . "($data)\n\t{\n\t\t" . $db . "\n\t}\n\t";
			}

			if ($value == 'update') {
				$db = 'return $this->db->update' . '($this->table, $data)->where($where)->execute();';
				$function .= "\n\tpublic function " . $value . "($data, $where)\n\t{\n\t\t" . $db . "\n\t}\n\t";
			}

			if ($value == 'delete') {
				$db = 'return $this->db->delete' . '($this->table)->where($where)->execute();';
				$function .= "\n\tpublic function " . $value . "($where)\n\t{\n\t\t" . $db . "\n\t}\n\t";
			}

			if ($value == 'select') {
				$row = '$row = "findAll"';
				$db = 'if ($where == NULL) {' . "\n\t\t\t" . 'return $this->db->get' . '($this->table)->{$row}();' . "\n\t\t}";
				$db .= ' else {' . "\n\t\t\t" . 'return $this->db->get_where' . '($this->table, $where)->{$row}();' . "\n\t\t}";
				$function .= "\n\tpublic function " . $value . "($where = NULL, $row)\n\t{\n\t\t" . $db . "\n\t}\n\t";
			}
		}

		$database = '$this->database();';
		$code = "<?php\ndefined('APP_PATH') OR exit('No direct script access allowed');\nclass " . ucfirst($table) . " extends Base_Model\n{\n";
		$code .= "\t" . 'public $table = ' . "'{$table}';\n\n" . '';
		$code .= "\tpublic function __construct()\n\t{\n\t\t$database\n\t}\n\t$function";
		$code .= "\n}\n?>";

		$table = str_replace('tbl_', '', $table);

		if (!file_exists(path() . model_path . DIRECTORY_SEPARATOR . $modelPath . ucfirst($table) . '.php')) {
			$file = fopen(path() . model_path . DIRECTORY_SEPARATOR . $modelPath . ucfirst($table) . '.php', 'w');
			fwrite($file, $code);
		}

		return TRUE;
	}
}
