<?php
defined('APP_PATH') OR exit('No direct script access allowed');

function template($title, $content='') {
    return "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>".ucwords($title)."</title>
    <link href='".APP_URL."/".APP_PATH."web/system/css/main.css' rel='stylesheet'>
</head>
<body>
    $content
</body>
</html>";
}