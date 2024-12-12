<?php 
use Rangel\Tcc\Controller\NotFoundController;

define("ROOT_DIR", __DIR__ . '/../');

require_once ROOT_DIR . 'vendor/autoload.php';
require_once ROOT_DIR . 'config/ControllerRoutes.php';

use Rangel\Tcc\Entity\Request;

$path_info = $_SERVER['PATH_INFO'] ?? '/';
$request_method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$params = $request_method === 'GET' ? $_GET : $_POST;

$request = new Request($path_info, $request_method, $params);
$classController = ControllerRoutes::getController($request) ?? NotFoundController::class;
$controller = new $classController;
$controller->request($request);