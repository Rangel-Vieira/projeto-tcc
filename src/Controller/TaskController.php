<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Libs\Objectfy\Objectfy;
use Rangel\Tcc\Entity\Request;
use Rangel\Tcc\Entity\Task;
use Rangel\Tcc\Service\TaskService;
use Rangel\Tcc\Controller\NotFoundController;

class TaskController extends Controller{

    private TaskService $taskService;

    public $endpoints = [
        'GET|/task'             => 'toVisualizeTask',
        'GET|/task/new'         => 'toNewTask',
        'GET|/task/edit'        => 'toEditTask',
        'POST|/task/createEdit' => 'toCreateEditTask'
    ];

    public function __construct(){
        $this->taskService = new TaskService();
    }

    public function request(Request $request): void{
        parent::processRequest($request, $this);
    }

    public function toEditTask(Request $request){
        $task = $this->getTaskOrNotFound($request);
        require_once ROOT_DIR . 'views/formTask.php';
    }

    public function toNewTask(){
        require_once ROOT_DIR . 'views/formTask.php';
    }

    public function toVisualizeTask(Request $request){
        $task = $this->getTaskOrNotFound($request);
        require_once ROOT_DIR . 'views/viewTask.php';
    }

    public function toCreateEditTask(Request $request){
        $task = $this->setTask($request);

        if(!is_null($task->getId())){
            $this->taskService->update($task->id, $task->parseToDatabase());
        }
        else{
            $this->taskService->save($task->parseToDatabase());
        }
    }

    private function getTaskOrNotFound(Request $request): array{
        $id = $request->getRequestParam('id');
        if(empty($id)) { $this->notFound($request); }

        $task = $this->taskService->findById($id);
        if(empty($task)) { $this->notFound($request); }

        return $task[0];
    }

    private function notFound(Request $request){
        if(empty($task)) { 
            $notFound = new NotFoundController();
            $notFound->request($request);
            exit();
        }
    }

    private function setTask(Request $request): Task{
        $convertion = [
            'input-id'          => 'id',
            'input-title'       => 'title',
            'input-description' => 'description',
            'input-date'        => 'doneDate',
            'input-status'      => 'status',
            'input-image'       => 'imageURL'
        ];
        
        $origin = $request->getRequestParams();
        $parsed = Objectfy::parseArray($convertion, $origin);
        $parsed['doneDate'] = $parsed['doneDate'] ? "new DateTimeImmutable('". $parsed['doneDate'] ."')" : null;

        $task = Objectfy::arrayToClass($parsed, Task::class);
        return $task;
    }
}