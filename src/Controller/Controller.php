<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Tcc\Entity\Request;
use Rangel\Tcc\Controller\NotFoundController;

interface IController{
    public function request(Request $request): void;
}

abstract class Controller implements IController {

    public function processRequest(Request $request, object $caller = null): void{
        $callMethod = $caller->endpoints[$request->__toString()];

        if(!method_exists($caller, $callMethod)){
            $this->notFound($request);
            exit();
        }

        $caller->$callMethod($request);
    }

    private function notFound(Request $request){
        $notFound = new NotFoundController();
        $notFound->request($request);
    }
}