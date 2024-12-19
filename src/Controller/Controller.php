<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Libs\Objectfy\Objectfy;
use Rangel\Tcc\Entity\Request;

interface IController{
    public function request(Request $request): void;
    public function notFound(): void;
}

abstract class Controller implements IController {

    public function processRequest(Request $request, object $caller = null): void{
        $callMethod = $caller->endpoints[$request->__toString()];

        if(!method_exists($caller, $callMethod)){
            $caller->notFound($request);
            exit;
        }

        $caller->$callMethod($request);
        exit;
    }

    public function navigateTo(Request $request): void{
        $_SESSION['SERVER_REQUEST'] = Objectfy::getObjectKeysAndValues($request);

        header('Location: ' . $request->getPath());
    }
}