<?php
defined('APP_PATH') or exit('No direct script access allowed');
//URL Helper
function base_url($url = '')
{
	return APP_URL . '/' . APP_PATH . $url;
}

function site_url($url = '')
{
	return APP_URL . '/' . APP_PATH . $url;
}

function media_url($url = '')
{
	return APP_URL . '/' . APP_PATH . 'web/' . $url;
}

function redirect($url = '')
{
	header('Location:' . APP_URL . '/' . APP_PATH . $url);
}
