<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Tcc\Entity\Request;

class HomeController extends Controller{

    private $teste;

    public function request(Request $request): void{
        parent::processRequest($request, $this);
    }

    private function toHome(){

    }

}