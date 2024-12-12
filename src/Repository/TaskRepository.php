<?php 

namespace Rangel\Tcc\Repository;
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

    public function findById(string $id): array{
        return $this->tbTaskRepository->findById($id);
    }

    public function list(int $limit, int $offset): array{
        return $this->tbTaskRepository->findByQuery(limit:$limit, offset:$offset);
    }

    public function save(object $object): void{
        $this->tbTaskRepository->add($object);
    }

    public function delete(int $id): void{
        $this->tbTaskRepository->remove($id);
    }

    public function update(int $id, object $object): void{
        $this->tbTaskRepository->update($id, $object);
    }

}