<?php
//Application live url
$config['APP_URL'] = "http://myworkspace.com";

//Application index Page
$config['APP_PAGE'] = "index.php";

//Application Environment
$config['APP_ENV'] = "development"; //production

//Allowed URL Character Rules
$config['URL_CHAR'] = "a-z 0-9~%.:_\-";

//Application Base Dir Path
$config['BASE_URL'] = $_SERVER['DOCUMENT_ROOT'];

//Allow IP For Code Generator
$config['ALLOW_IP'] = ['127.0.0.1', '192.168.43.207'];
