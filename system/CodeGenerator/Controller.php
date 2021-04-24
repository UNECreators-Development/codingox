<?php
defined('APP_PATH') OR exit('No direct script access allowed');

require_once('AppPath.php');
require_once('template.php');
function controller($class, $action, $viewPath)
{
    $function = "";
    $base_path = path();

    $fileName = explode('.', $class);
    $action = explode(',', $action);
    $viewPath = str_replace('\\', '/', $viewPath);
    $viewPath = explode('/', $viewPath);
    unset($viewPath[0]);
    $viewPath = array_values($viewPath);
    $viewPath = implode('/', $viewPath) . '/';
    $helper = '$this->helper("html", "url");';

    for ($i = 0; $i < sizeof($action); $i++) {
        $view = '$this->view("' . $viewPath . $action[$i] . '");';
        $function .= "\n\tpublic function " . $action[$i] . "()\n\t{\n\t\t" . $view . "\n\t}\n\t";
    }

    $code = "<?php\ndefined('APP_PATH') OR exit('No direct script access allowed');\nclass " . ucfirst($fileName[0]) . " extends My_Controller\n{\n";
    $code .= "\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t\t$helper\n\t}\n\t$function";
    $code .= "\n}\n?>";

    if (!file_exists($base_path . 'Controllers/' . ucfirst($fileName[0]) . '.php')) {
        $file = fopen($base_path . 'Controllers/' . ucfirst($fileName[0]) . '.php', 'w');
        fwrite($file, $code);
    }

    if (!file_exists($base_path . 'views/' . $viewPath)) {
        mkdir($base_path . 'views/' . $viewPath);
    }

    for ($i = 0; $i < sizeof($action); $i++) {
        if (!file_exists($base_path . 'views/' . $viewPath . $action[$i] . '.php')) {
            $html = "<div class='container'>\n\t\t<h4 class='text-center mt-5'>This is auto generated view of ".ucfirst($fileName[0])."/".ucfirst($action[$i])."</h4>\n\t</div>";
            $file = fopen($base_path . 'views/' . $viewPath . $action[$i] . '.php', 'w');
            fwrite($file, template($fileName[0].' | '.ucwords($action[$i]), $html));
        }
    }
}
