<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Tcc\Entity\Request;
use Rangel\Tcc\Repository\TaskRepository;
use Rangel\Tcc\Service\TaskService;

class HomeController extends Controller{
    private TaskService $taskService;

    public $endpoints = [
        'GET|/'  => 'toHome'
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

    public function toHome(Request $request){
        $page = $request->getRequestParam('page') ?? 1;
        $itemsByPage = $request->getRequestParam('itemsByPage') ?? 12;

        $found = $this->taskService->list($page-1, $itemsByPage, 50);
        $items = $found['items'];
        $pages = $found['pages'];

        $message = '';
        $status = '';

        if($request->isServerRequest()){
            $message = $request->getRequestParam('message');
            $status  = $request->getRequestParam('status');
        }
        
        require_once ROOT_DIR . 'views/home.php';
    }
}