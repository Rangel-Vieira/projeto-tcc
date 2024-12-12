<?php 

namespace Rangel\Tcc\Controller;
use Rangel\Tcc\Entity\Request;
use Rangel\Tcc\Repository\TaskRepository;
use Rangel\Tcc\Service\TaskService;

class HomeController extends Controller{
    private TaskService $taskService;

    public function __construct(){
        $this->taskService = new TaskService();
    }

    public $endpoints = [
        'GET|/'  => 'toHome'
    ];

    public function request(Request $request): void{
        parent::processRequest($request, $this);
    }

    public function toHome(Request $request){
        $page = $request->getRequestParam('page') ?? 0;
        $itemsByPage = $request->getRequestParam('itemsByPage') ?? 10;

        $items = $this->taskService->list($page, $itemsByPage, 50);
        require_once ROOT_DIR . 'views/home.php';
    }
}