<?php
    /* This file is used to load whole project */
    require('config/config.php'); //Do Not Remove This Line.
    require('config/router.php'); //Do Not Remove This Line.
    
    //Application Environment
    if ($config['APP_ENV'] == "production") {
        error_reporting(0);
    }else {
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
        $base_path.= $key.'/';
    }
    
    //Match Page Request
    foreach ($router as $key => $value) {
        if (isset($page[0])) {
            if ($page[0] == $key) {
                $page = null;
                $page = explode('/', $value);
            }
        }
    }

    if (sizeof($page) == 0) {
        $page = null;
        $page[] = $router['default'];
        $page[] = "index"; 
    }else if (sizeof($page) == 1) {
        $page[] = "index";
    }
    
    //Define Variables
    define('APP_PATH', $base_path);
    define('APP_URL', $config['APP_URL']);

    //Load Code Generator
    if ($page[0] == 'CodeGenerator') {
        $ip = false;
        for ($i = 0; $i < sizeof($config['ALLOW_IP']); $i++) {
            if ($_SERVER['REMOTE_ADDR'] == $config['ALLOW_IP'][$i]) {
                $ip = true;
            }
        }

        if ($ip == true) {
            require_once('system/CodeGenerator/Generator.php');
            exit();
        }
    }

    //load controller
    $class = ucwords($page[0]);
    spl_autoload_register(function($class) {
        require_once('system/My_Controller.php');
        
        if (file_exists('controllers/'.$class.'.php')) {
            require('controllers/'.$class.'.php');
        }
    });

    try {
        $view = new ReflectionClass($class);
        $object = new $class;

        foreach ($view->getMethods() as $method) {
            if ($method->class == $class) {
                $methods[] = $method->name;
            }
        }

        $methods = array_values(array_filter(array_diff($methods, ['__construct'])));
        foreach ($methods as $key) {
            if ($page[1] == $key) {
                $count = 1;
                $view = $key;
            }
        }

        //load view
        if ($count > 0) {
            $object->$view();
        }else {
            $object->view('error/404');
        }  
    }catch (Exception $ex) {
        require($config['BASE_URL'].'/'.$base_path.'views/error/404.php');
    }
?>