<?php
defined('APP_PATH') or exit('No direct script access allowed');
class media
{
	public function upload($name, $config)
	{
		//Get Root Dir Path
		$base_path = "";
		$root = ['libraries'];
		$path = str_replace('\\', '/', __DIR__);
		$path = explode('/', $path);
		$path = array_values(array_filter(array_diff($path, $root)));

		foreach ($path as $key) {
			$base_path .= $key . '/';
		}

		if (APP_URL != "") {
			$base_path = "";
		}

		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//Dir Path To Upload File
			$target_dir  = $base_path . 'web/' . $config['path'];
			//Allowed Extension To Upload
			$extension   = explode('|', $config['type']);
			//Target File To Upload
			$target_file = $target_dir . basename($_FILES["$name"]["name"]);
			//Type of Target File
			$FileType    = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

			//Check File Size
			if (isset($config['size'])) {
				if ($_FILES["$name"]["size"] <= ($config['size'] * 1024)) {
					foreach ($extension as $ext) {
						//Check File Type
						if ($ext == $FileType) {
							//Save File Into Dir
							(!file_exists($target_dir)) ? mkdir($target_dir) : "";
							move_uploaded_file($_FILES["$name"]["tmp_name"], $target_file);
							return true;
						}
					}
				} else {
					echo "Sorry, file is to large.";
				}
			} else {
				foreach ($extension as $ext) {
					//Check File Type
					if ($ext == $FileType) {
						//Save File Into Dir
						move_uploaded_file($_FILES["$name"]["tmp_name"], $target_file);
						return true;
					}
				}
			}
		}
	}
}
