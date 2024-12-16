<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Libs\Objectfy\Objectfy;
use Rangel\Tcc\Entity\Request;
use Rangel\Tcc\Entity\Task;
use Rangel\Tcc\Service\TaskService;
use Rangel\Tcc\Controller\NotFoundController;
use Rangel\Tcc\Service\FileService;

class TaskController extends Controller{

    private TaskService $taskService;

    public $endpoints = [
        'GET|/task'             => 'toVisualizeTask',
        'GET|/task/new'         => 'toNewTask',
        'GET|/task/edit'        => 'toEditTask',
        'POST|/task/createEdit' => 'toCreateOrEditTask',
        'GET|/task/delete'      => 'toDeleteTask'
    ];

    public function __construct(){
        $this->taskService = new TaskService();
    }

    public function request(Request $request): void{
        parent::processRequest($request, $this);
    }

    public function toVisualizeTask(Request $request){
        $task = $this->getTaskOrNotFound($request);
        require_once ROOT_DIR . 'views/viewTask.php';
    }

    public function toNewTask(){
        $task = new Task();
        $task->setDoneDate(new \DateTimeImmutable());

        require_once ROOT_DIR . 'views/formTask.php';
    }

    public function toEditTask(Request $request){
        $task = $this->getTaskOrNotFound($request);
        require_once ROOT_DIR . 'views/formTask.php';
    }

    public function toCreateOrEditTask(Request $request){
        $task = $this->setTask($request);

        if(!is_null($task->getId())){
            $this->taskService->update($task->getId(), $task, $request);
        }
        else{
            $this->taskService->save($task, $request);
        }

        echo 'A atividade foi salva com sucesso! (Rangel para de ser preguiçoso e faz um response decente :U)';
    }

    public function toDeleteTask(Request $request){
        $this->taskService->delete($request->getRequestParam('id'));
    }

    private function getTaskOrNotFound(Request $request): Task{
        $id = $request->getRequestParam('id');
        if(empty($id)) { $this->notFound($request); }

        $task = $this->taskService->findById($id);
        if(empty($task)) { $this->notFound($request); }

        return $task;
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
            'input-image'       => 'imageUrl'
        ];
        
        $imageName = $request->getRequestFile('input-image')['name'] ?? '';

        $origin = $request->getRequestParams();
        $parsed = Objectfy::parseArray($convertion, $origin);
        $parsed['id'] = empty($parsed['id']) ? null : (int)$parsed['id'];
        $parsed['doneDate'] = new \DateTimeImmutable($parsed['doneDate']);
        $parsed['imageUrl'] = !empty($imageName) ? FileService::generateUID() . '_' . $imageName : '';

        $task = Objectfy::arrayToClass($parsed, Task::class);
        return $task;
    }
}