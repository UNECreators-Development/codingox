<?php
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
        require_once('system/Code/Generator.php');
        exit();
    }
}

//load controller
$class = ucwords($page[0]);
spl_autoload_register(function ($class) {
    require_once('system/Core/Controller.php');

    if (file_exists('controllers/' . $class . '.php')) {
        require_once('controllers/' . $class . '.php');
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

    unset($page[0]);
    unset($page[1]);

    //load view
    if ($count > 0) {
        $object->$view(...$page);
    } else {
        $object->view('error/404');
        exit();
    }
} catch (Exception $ex) {
    require_once($config['BASE_URL'] . '/' . $base_path . 'views/error/404.php');
    exit();
}
