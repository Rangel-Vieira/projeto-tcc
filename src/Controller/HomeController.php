<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Tcc\Entity\Request;

class HomeController extends Controller{

    public $endpoints = [
        'GET|/'  => 'toHome'
    ];

    public function request(Request $request, object $caller = null): void{
        parent::processRequest($request, $this);
    }

    public function toHome(){
        require_once ROOT_DIR . 'views/home.php';
    }

}