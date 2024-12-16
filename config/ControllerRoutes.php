<?php 

use Rangel\Tcc\Controller\HomeController;
use Rangel\Tcc\Controller\TaskController;
use Rangel\Tcc\Entity\Request;

class ControllerRoutes {

    private static array $routes = [
        '/task' => TaskController::class,
        '/' => HomeController::class
    ];

    //TODO: Tem como melhorar esse sistema provavelmente, ele tem dois problemas: 
    // 1. Fica lento de acordo com o tamanho do vetor,
    // 2. A ordem do vetor influencia quem ele vai encontrar primeiro, como todo mundo tem /, o home sempre vai ser retornado primeiro;
    public static function getController(Request $request): string | null{
        $foundController = null;
        $requestPath = $request->getPath();

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