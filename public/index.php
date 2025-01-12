<?php 
use Rangel\Tcc\Controller\NotFoundController;
use Rangel\Tcc\Service\RequestService;

session_start();
define("ROOT_DIR", __DIR__ . '/../');

require_once ROOT_DIR . 'vendor/autoload.php';
require_once ROOT_DIR . 'config/ControllerRoutes.php';

$request = RequestService::getRequest();

$classController = ControllerRoutes::getController($request) ?? NotFoundController::class;
$controller = new $classController;
$controller->request($request);