<?php
/* This file is used to load whole project */
require('config/config.php'); //Do Not Remove This Line.
require('config/router.php'); //Do Not Remove This Line.

//Application Environment
if ($config['APP_ENV'] == "production") {
    error_reporting(0);
} else {
    error_reporting(E_ALL);
}

$count = 0;
$methods = array();
$base_path = ""; //Base Dir Path
$path = str_replace('\\', '/', __DIR__);
$path = explode('/', $path);
$root = explode('/', $config['BASE_URL']);
$path = array_values(array_filter(array_diff($path, $root)));

$page = array_values(array_filter(explode('/', $_SERVER['PHP_SELF'])));
$page = array_values(array_filter(array_diff($page, $path, [$config['APP_PAGE']])));

foreach ($path as $key) {
    $base_path .= $key . '/';
}

//Match Page Request
foreach ($router as $key => $value) {
    if (isset($page[0])) {
        if ($page[0] == $key) {
            $pageArray = explode('/', $value);
            array_unshift($page, $pageArray[0]);
            $page[1] = $pageArray[1];
        }
    }
}

if (sizeof($page) == 0) {
    $page[0] = $router['default'];
    $page[1] = "index";
} else if (sizeof($page) == 1) {
    $page[1] = "index";
}

require_once('config/loader.php');
exit();
