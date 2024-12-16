<?php 

namespace Rangel\Tcc\Service;
use Rangel\Tcc\Entity\Task;
use Rangel\Tcc\Repository\TaskRepository;

class TaskService {

    private TaskRepository $taskRepository;

    public function __construct(){
        $this->taskRepository = new TaskRepository();
    }

    /**
     * Retorna a quantidade de items paginada.
     * @param integer $page recebe qual o número da página a ser mostrada
     * @param integer $itemsByPage recebe o número de itens a mostrar por página
     * @param integer $itemsLimit um limite "hardcoded" que não permite o usuário ultrapassar essa quantidade de itens exibidos por paginação
     */
    public function list(int $page = 0, int $itemsByPage = 10, int $itemsLimit = 50): array{
        if($itemsByPage == 0) { return []; }
        if($itemsByPage > $itemsLimit) { $itemsByPage = $itemsLimit; }
        
        $totalInDatabase = $this->taskRepository->getTableCount();
        $pageQty = floor($totalInDatabase / $itemsByPage);

        if($page < 0){
            $page = 0;
        }

        if($page > $pageQty){
            $page = $pageQty;
        }

        $offset = $page * $itemsByPage;
        return $this->taskRepository->list($itemsByPage, $offset);
    }

    public function findById(string $id){
        return $this->taskRepository->findById($id);
    }

    public function save(Task $task){
        $this->taskRepository->save($task);
    }

    public function update(int $id, Task $task){
        $this->taskRepository->update($id, $task);
    }

}