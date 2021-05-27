<?php
defined('APP_PATH') or exit('No direct script access allowed');
require_once('template.php');

if (!function_exists('form')) {
	/**
	 * Generate Form
	 * @param	string $fileName	(view name)
	 * @param	string $fields 		(field name)
	 * @param	string $viewPath	(view dir path)
	 * @return	bool
	 **/
	function form($fileName, $fields, $viewPath)
	{
		$input = "";
		$fileName = explode('.', $fileName);
		$fields = explode(',', $fields);
		$viewPath = str_replace('\\', '/', $viewPath);
		$viewPath = explode('/', $viewPath);
		unset($viewPath[0]);
		$viewPath = array_values($viewPath);
		$viewPath = implode('/', $viewPath) . DIRECTORY_SEPARATOR;

		for ($i = 0; $i < sizeof($fields); $i++) {
			$field = "<label for='" . $fields[$i] . "'>" . ucfirst($fields[$i]) . "</label>\n\t\t\t\t<input type='text' name='" . $fields[$i] . "' id='" . $fields[$i] . "' class='form-control' placeholder='Enter " . $fields[$i] . "' required />";
			$input .= "\t\t\t<div class='form-group'>\n\t\t\t\t$field\n\t\t\t</div>\n";
		}

		$input .= "\t\t\t<div class='form-group'>\n\t\t\t\t<button type='submit' class='btn btn-success'>Submit</button>\n\t\t\t</div>\n";

		$content = "<div class='container'>\n\t\t<form action='' method='post'>\n$input\t\t</form>\n\t</div>";
		$form = template($fileName[0], $content);

		if (!file_exists(path() . view_path . DIRECTORY_SEPARATOR . $viewPath)) {
			mkdir(path() . view_path . DIRECTORY_SEPARATOR . $viewPath);
		}

		if (!file_exists(path() . view_path . DIRECTORY_SEPARATOR . $viewPath . $fileName[0] . '.php')) {
			$file = fopen(path() . view_path . DIRECTORY_SEPARATOR . $viewPath . $fileName[0] . '.php', 'w');
			fwrite($file, $form);
		}

		return true;
	}
}
