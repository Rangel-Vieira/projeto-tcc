<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Tcc\Entity\Request;

interface IController{
    public function request(Request $request, object $caller = null): void;
}

abstract class Controller implements IController {
    public function processRequest(Request $request, object $caller = null): void{
        echo $caller;
        exit;
    }
}