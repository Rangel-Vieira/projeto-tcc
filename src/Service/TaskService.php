<?php 

namespace Rangel\Tcc\Service;
use Rangel\Libs\ParseConvention\ParseConvention;
use Rangel\Libs\ParseConvention\PARSE_MODE;
use Rangel\Tcc\Entity\Request;
use Rangel\Tcc\Entity\Task;
use Rangel\Tcc\Repository\TaskRepository;
use Rangel\Tcc\Service\FileService;

class TaskService {

    private TaskRepository $taskRepository;
    private FileService $imgService;
    

    public function __construct(){
        $this->taskRepository = new TaskRepository();
        $this->imgService = new FileService('media/img');
    }

    /**
     * Retorna a quantidade de items paginada.
     * @param integer $page recebe qual o número da página a ser mostrada
     * @param integer $itemsByPage recebe o número de itens a mostrar por página
     * @param integer $itemsLimit um limite "hardcoded" que não permite o usuário ultrapassar essa quantidade de itens exibidos por paginação
     */
    public function list(int $page = 1, int $itemsByPage = 10, int $itemsLimit = 50): array{
        if($itemsByPage == 0)
            return [];
        
        if($itemsByPage > $itemsLimit)
            $itemsByPage = $itemsLimit;
        
        if($page < 0) 
            $page = 0;
        
        $totalInDatabase = $this->taskRepository->getTableCount();
        $pageQty = ceil($totalInDatabase / $itemsByPage);

        if($page > $pageQty)
            $page = $pageQty;

        $offset = $page * $itemsByPage;
        return ['pages' => $pageQty, 'items' => $this->taskRepository->list($itemsByPage, $offset)];
    }

    public function findById(string $id){
        return $this->taskRepository->findById($id);
    }

    public function save(Task $task, Request $request){
        $taskToDatabase = ParseConvention::parse($task, PARSE_MODE::camelToSnake);
        $taskToDatabase['done_date'] = $taskToDatabase['done_date']->format('Y-m-d');

        $this->taskRepository->save($taskToDatabase);
        if($task->getimageUrl()){
            $this->imgService->save($request->getRequestFile('input-image'), $task->getimageUrl(), 3000000, ['image/png', 'image/gif', 'image/jpeg']);
        }
    }

    public function update(int $id, Task $task, Request $request){
        $oldTask = $this->findById($id);
        $taskToDatabase = ParseConvention::parse($task, PARSE_MODE::camelToSnake);
        $taskToDatabase['done_date'] = $taskToDatabase['done_date']->format('Y-m-d');

        if($task->getimageUrl()){
            $this->imgService->remove($oldTask->getimageUrl());
            $this->imgService->save($request->getRequestFile('input-image'), $task->getimageUrl(), 3000000, ['image/png', 'image/gif', 'image/jpeg']);
        }

        $this->taskRepository->update($id, $taskToDatabase);
    }

    public function delete(int $id): void{
        $task = $this->findById($id);
        
        if($task->getImageUrl()){
            $this->imgService->remove($task->getimageUrl());
        }

        $this->taskRepository->delete($task->getId());
    }

}