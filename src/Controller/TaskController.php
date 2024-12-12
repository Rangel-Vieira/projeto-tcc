<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Tcc\Entity\Request;
use Rangel\Tcc\Service\TaskService;
use Rangel\Tcc\Controller\NotFoundController;

class TaskController extends Controller{

    private TaskService $taskService;

    public function __construct(){
        $this->taskService = new TaskService();
    }

    public $endpoints = [
        'GET|/task'      => 'toVisualizeTask',
        'GET|/task/new'  => 'toNewTask',
        'GET|/task/edit' => 'toEditTask'
    ];

    public function request(Request $request): void{
        parent::processRequest($request, $this);
    }

    public function toEditTask(){
        require_once ROOT_DIR . 'views/formTask.php';
    }

    public function toNewTask(){
        require_once ROOT_DIR . 'views/formTask.php';
    }

    public function toVisualizeTask(Request $request){
        $id = $request->getRequestParam('id');
        if(empty($id)) { $this->notFound($request); }

        $task = $this->taskService->findById($id);
        if(empty($task)) { $this->notFound($request); }
        
        $task = $task[0];
        require_once ROOT_DIR . 'views/viewTask.php';
    }

    private function notFound(Request $request){
        if(empty($task)) { 
            $notFound = new NotFoundController();
            $notFound->request($request);
            exit();
        }
    }
}