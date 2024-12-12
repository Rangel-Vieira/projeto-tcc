<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Tcc\Entity\Request;

class NotFoundController extends Controller{

    public $endpoints = [];

    public function request(Request $request): void{
        $this->notFound();
    }

    public function notFound(){
        require_once ROOT_DIR . 'views/notFound.php';
    }

}