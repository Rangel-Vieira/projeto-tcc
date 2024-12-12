<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Tcc\Entity\Request;

class TaskController extends Controller{

    public $endpoints = [
        'GET|/task'      => 'toVisualizeTask',
        'GET|/task/new'  => 'toNewTask',
        'GET|/task/edit' => 'toEditTask'
    ];

    public function request(Request $request, object $caller = null): void{
        parent::processRequest($request, $this);
    }

    public function toEditTask(){
        require_once ROOT_DIR . 'views/formTask.php';
    }

    public function toNewTask(){
        require_once ROOT_DIR . 'views/formTask.php';
    }

    public function toVisualizeTask(){
        require_once ROOT_DIR . 'views/viewTask.php';
    }
}