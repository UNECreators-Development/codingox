<?php
defined('APP_PATH') OR exit('No direct script access allowed');
function path()
{
    $base_path = "";
    $root = ['system', 'Code'];
    $path = str_replace('\\', '/', __DIR__);
    $path = explode('/', $path);

    $path = array_values(array_filter(array_diff($path, $root)));

    foreach ($path as $key) {
        $base_path .= $key . '/';
    }

    if (APP_URL != "") {
        $base_path = "";
    }

    return $base_path;
}
