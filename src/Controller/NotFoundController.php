<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Tcc\Entity\Request;

class NotFoundController extends Controller{

    public $endpoints = [];

    public function request(Request $request): void{
        $this->toNotFound();
    }

    public function notFound(): void{
        self::toNotFound();
        exit;
    }

    public static function toNotFound(){
        require_once ROOT_DIR . 'views/notFound.php';
        exit();
    }

}