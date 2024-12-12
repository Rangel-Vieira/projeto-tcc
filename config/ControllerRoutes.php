<?php 

use Rangel\Tcc\Controller\HomeController;
use Rangel\Tcc\Controller\TaskController;
use Rangel\Tcc\Entity\Request;

class ControllerRoutes {

    private static array $routes = [
        'GET|/task' => TaskController::class,
        'GET|/' => HomeController::class
    ];

    //TODO: Tem como melhorar esse sistema provavelmente, ele tem dois problemas: 
    // 1. Fica lento de acordo com o tamanho do vetor,
    // 2. A ordem do vetor influencia quem ele vai encontrar primeiro, como todo mundo tem /, o home sempre vai ser retornado primeiro;
    public static function getController(Request $request): string{
        $foundController = null;
        $requestPath = $request->__toString();

        foreach(self::$routes as $path => $controller){
            if(str_starts_with($requestPath, $path)){
                $foundController = $controller;
                break;
            }
        }
        
        return $foundController;
    }

    public static function getRoutes(): array{
        return self::$routes;
    }

}