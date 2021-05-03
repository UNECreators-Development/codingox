<?php
defined('APP_PATH') OR exit('No direct script access allowed');

require_once('AppPath.php');
require_once('template.php');

function form($fileName, $fields, $viewPath)
{
    $input = "";
    $base_path = path();

    $fileName = explode('.', $fileName);
    $fields = explode(',', $fields);
    $viewPath = str_replace('\\', '/', $viewPath);
    $viewPath = explode('/', $viewPath);
    unset($viewPath[0]);
    $viewPath = array_values($viewPath);
    $viewPath = implode('/', $viewPath) . '/';

    for ($i = 0; $i < sizeof($fields); $i++) {
        $field = "<label for='" . $fields[$i] . "'>" . ucfirst($fields[$i]) . "</label>\n\t\t\t\t<input type='text' name='" . $fields[$i] . "' id='" . $fields[$i] . "' class='form-control' placeholder='Enter " . $fields[$i] . "' required />";
        $input .= "\t\t\t<div class='form-group'>\n\t\t\t\t$field\n\t\t\t</div>\n";
    }

    $input .= "\t\t\t<div class='form-group'>\n\t\t\t\t<button type='submit' class='btn btn-success'>Submit</button>\n\t\t\t</div>\n";

    $content = "<div class='container'>\n\t\t<form action='' method='post'>\n$input\t\t</form>\n\t</div>";
    $form = template($fileName[0], $content);

    if (!file_exists($base_path . 'views/' . $viewPath)) {
        mkdir($base_path . 'views/' . $viewPath);
    }

    // if (!file_exists($base_path . 'views/' . $viewPath . $fileName[0] . '.php')) {
        $file = fopen($base_path . 'views/' . $viewPath . $fileName[0] . '.php', 'w');
        fwrite($file, $form);
    // }
}
