<?php
defined('APP_PATH') or exit('No direct script access allowed');
require_once('AppPath.php');
class Database
{
	public function DBConnection($arg)
	{
		$base_path = path();

		require($base_path . 'config/database.php');

		$value = $arg == '' ? 'default' : $arg;
		$db = $arg == '' ? $database['default'] : $database[$arg];

		$connectionObject = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);

		if ($connectionObject) :
			$this->{$value} = $connectionObject;
		else :
			return die(mysqli_connect_error());
		endif;
	}
}
