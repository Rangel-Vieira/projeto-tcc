<?php 

namespace Rangel\Tcc\Controller;
use Exception;
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

    public function notFound(): void{
        NotFoundController::toNotFound();
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

        try{
            if(!is_null($task->getId())){
                $action = 'atualizada';
                $this->taskService->update($task->getId(), $task, $request);
            }
            else{
                $action = 'criada';
                $this->taskService->save($task, $request);
            }
    
            $request = new Request('/', 'GET', ['message' => 'A atividade foi ' . $action . ' com sucesso.', 'status' => 'success']);
        }
        catch(Exception $e){
            $request = new Request('/', 'GET', ['message' => 'Um erro ocorreu :(, tente novamente mais tarde.', 'status' => 'error']);
        }

        parent::navigateTo($request);
    }

    public function toDeleteTask(Request $request){
        try{
            $this->taskService->delete($request->getRequestParam('id'));
            $request = new Request('/', 'GET', ['message' => 'A atividade foi excluída com sucesso.', 'status' => 'success']);
        }
        catch(Exception $e){
            $request = new Request('/', 'GET', ['message' => 'Um erro ocorreu :(, tente novamente mais tarde.', 'status' => 'error']);
        }

        parent::navigateTo($request);
    }

    private function getTaskOrNotFound(Request $request): Task{
        $id = $request->getRequestParam('id') ?? null;
        if(empty($id)) 
            NotFoundController::toNotFound();

        $task = $this->taskService->findById($id);
        if(empty($task))
            NotFoundController::toNotFound();

        return $task;
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
        $parsed['imageUrl'] = !empty($imageName) ? FileService::generateUID() . '_' . $imageName : null;

        $task = Objectfy::arrayToClass($parsed, Task::class);
        return $task;
    }
}