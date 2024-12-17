<?php 

namespace Rangel\Tcc\Repository;
use Rangel\Libs\Objectfy\Objectfy;
use Rangel\Libs\ParseConvention\ParseConvention;
use Rangel\Libs\ParseConvention\PARSE_MODE;
use Rangel\Tcc\Entity\Task;
use Rangel\Tcc\Repository\IRepository;
use Rangel\Libs\Repository\Repository;
use Rangel\Config\Connection;

class TaskRepository implements IRepository {

    private readonly Repository $tbTaskRepository;

    public function __construct(){
        $this->tbTaskRepository = new Repository(Connection::getConnection(), 'tb_task', 'id');
    }

    public function getLastInsertedId(): string{
        return $this->tbTaskRepository->getLastInsertedId();
    }

    public function getTableCount(): int{
        return $this->tbTaskRepository->getTableCount();
    }

    public function findById(string $id): Task|null{
        $task = $this->tbTaskRepository->findById($id)[0] ?? null;
        
        if(!$task){
            return null;
        }

        $parsed = ParseConvention::parse($task, PARSE_MODE::snakeToCamel);
        $parsed['doneDate'] = new \DateTimeImmutable($parsed['doneDate']);

        $task = Objectfy::arrayToClass($parsed, Task::class);
        return $task;
    }

    public function list(int $limit, int $offset): array{
        $foundItems = [];
        $items = $this->tbTaskRepository->findByQuery(limit:$limit, offset:$offset);

        foreach($items as $item){
            $parsed = ParseConvention::parse($item, PARSE_MODE::snakeToCamel);
            $parsed['doneDate'] = new \DateTimeImmutable($parsed['doneDate']);

            $foundItems[] = Objectfy::arrayToClass($parsed, Task::class);
        }

        return $foundItems;
    }

    public function save(array|object $object): void{
        $this->tbTaskRepository->add($object);
    }

    public function delete(int $id): void{
        $this->tbTaskRepository->remove($id);
    }

    public function update(int $id, array|object $object): void{
        $this->tbTaskRepository->update($id, $object);
    }

}