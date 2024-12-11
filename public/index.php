<?php 

define("ROOT_DIR", __DIR__ . '/../');

require_once ROOT_DIR . 'vendor/autoload.php';
require_once ROOT_DIR . 'config/routes.php';

$PATH_INFO = $_SERVER['PATH_INFO'] ?? '/';
$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'] ?? 'GET';

function navigate(string $url){
    require_once $url;
}

$foundPath = ROUTES[$REQUEST_METHOD . '|' . $PATH_INFO];
if(!$foundPath){
    header('Location: /');
    exit();
}

navigate($foundPath);