<?php

namespace Rangel\Libs\Repository;
use Rangel\Libs\Objectfy\Objectfy;
use Rangel\Libs\SecureSql\SecureSql;
use PDO;
use Exception;
use PDOStatement;

class Repository {
    
    private PDO $connection;
    private string $table;
    private string $id_key;

    public function __construct(PDO $connection, string $table, string $id_key = ''){
        $this->connection = $connection;
        $this->table = SecureSql::removeUnsafeChars($table);
        $this->id_key = SecureSql::removeUnsafeChars($id_key);
    
        $this->configConnection();
    }

    private function configConnection(){
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function getLastInsertedId(): int{
        return $this->connection->lastInsertId();
    }
    
    public function findAll(): array{
        return $this->fetch();
    }

    public function findById(string $id): array{
        $this->validateTableId();

        return $this->fetch(filters: $this->id_key . ' = :id', filterValues:[$id]);
    }

    public function findByQuery(string $fields = '*', string $filters = '1', array $filterValues = [], string $orderBy = '1', int $limit = -1, int $offset = 0): array{
        return $this->fetch($fields, $filters, $filterValues, $orderBy, $limit, $offset);
    }

    public function add(object $object): bool{
        Objectfy::checkIfObjectIsValid($object);

        $statement = $this->prepareInsert($object);
        $statement->execute();

        return true;
    }

    public function update(string $id, object $object): bool{
        $this->validateTableId();
        Objectfy::checkIfObjectIsValid($object);
        $this->checkIfObjectExists($id);
        
        $statement = $this->prepareUpdate($id, $object);
        $statement->execute();

        return true;
    }

    public function remove(string $id): bool{
        $this->validateTableId();
        
        $statement = $this->prepareDelete($id);
        $statement->execute();

        return true;
    }

    private function validateTableId(): bool{
        if(empty($this->id_key)) 
            throw new Exception('Certifique-se de colocar o nome do campo da chave primária ($id_key) da tabela ' . $this->table . ' na instanciação da classe Repository');
        
        return true;
    }

    private function checkIfObjectExists(string $id): bool{
        $exists = $this->findById($id) ?? false;
        if(!$exists){
            throw new Exception("O ID " . $id . " não foi encontrado na tabela " . $this->table);
        }

        return true;
    }

    private function fetch(string $fields = '*', string $filters = '1', array $filterValues = array(), string $orderBy = '1', int $limit = -1, int $offset = 0): array{

        $statement = $this->prepareSelect($fields, $filters, $filterValues, $orderBy, $limit, $offset);
        $statement->execute();

        $read = array();
        while($dbRead = $statement->fetch(PDO::FETCH_ASSOC)){
            $read[] = $dbRead;
        }

        return $read;
    }

    //TODO: Ainda pode ter uma vulnerabilidade, que seria colocar vários comandos no input: exemplo: ao invés de filtro ser "id = :id", for enviado "id = :id ORDER BY", algo assim.
    //Provavelmente só vai explodir por ter dois comandos iguais, mas é algo a se testar; 
    private function prepareSelect(string $fields = '*', string $filters = '1', array $filterValues = array(), string $orderBy = '1', int $limit = -1, int $offset = 0): PDOStatement{
        
        $statement = null;
        $filterKeys = array();

        $query = ' SELECT '   . SecureSql::removeUnsafeChars($fields)  .
                 ' FROM '     . $this->table                           .
                 ' WHERE '    . SecureSql::removeUnsafeChars($filters) .
                 ' ORDER BY ' . SecureSql::removeUnsafeChars($orderBy) .
                 ' LIMIT '    . $offset . ',' . $limit                 ;

        $filterKeys = $this->getFilterKeys($filters);
        $binds = $this->normalizeArrayBindsAndQuery($query, $filterKeys, $filterValues);

        $statement = $this->connection->prepare($query);
        foreach($binds as $bind){
            $statement->bindValue($bind['key'], $bind['value']);
        }

        return $statement;
    }

    private function normalizeArrayBindsAndQuery(string &$query, array $filterKeys = [], $filterValues = []): array{
        $binds = [];

        foreach($filterKeys as $idx => $filterKey){
            if(empty($filterValues[$idx])){
                throw new Exception('Todos os campos do where devem possuir valores! Os adicione na lista de filterValues. Campo que não possui valor: ' . str_replace(':', '', $filterKey));
            }

            $binds = array_merge($binds, $this->getBindAndQuery($query, $filterKey, $filterValues[$idx]));
        }

        return $binds;
    }

    private function getBindAndQuery(string &$query, string $filterKey, mixed $bind): array{
        $keys = [];
        $values = [];
        $binds = [];

        switch(gettype($bind)){
            case 'array':
                foreach($bind as $idx => $vl){
                    $keys[] = ($filterKey . '__' . $idx);
                    $values[] = $vl;
    
                    $binds[] = ['key' => $keys[$idx], 'value' => $values[$idx]];
                }

                $query = str_replace($filterKey, implode(',', $keys), $query);
            break;
            default:
                $binds[] = ['key' => $filterKey, 'value' => $bind];
            break;
        }

        return $binds;
    }

    private function getFilterKeys(string $filters): array{
        
        $pragma = '/:([^)\s]+)/';
        $foundKeys = array();
        preg_match_all($pragma, $filters, $foundKeys);

        return $foundKeys[0];
    }

    private function prepareInsert(object $object): PDOStatement{

        $statement = null;
        $objectKeyAndValues = Objectfy::getObjectKeysAndValues($object);
        $objectKeys = Objectfy::getArrayKeys($objectKeyAndValues);
        $objectBinds = Objectfy::getArrayKeys($objectKeyAndValues, ":");

        $query = ' INSERT INTO ' . $this->table . '(' . implode(',', $objectKeys) . ')' .  
                 ' VALUES ('     . implode(',', $objectBinds) . ')'                     ;

        $statement = $this->connection->prepare($query);

        foreach($objectKeyAndValues as $key => $value){
            $objKey = ":" . $key;
            
            $statement->bindValue($objKey, $value);
        }

        return $statement;
    }

    private function prepareUpdate(string $id, object $object): PDOStatement{

        $statement = null;
        $objectKeyAndValues = Objectfy::getObjectKeysAndValues($object);
        $objectKeyAndValues = array_filter($objectKeyAndValues, function($element) { return !(empty($element) || is_null($element)); });
        $objectKeys = Objectfy::getArrayKeys($objectKeyAndValues);

        $query = ' UPDATE ' . $this->table                             .
                 ' SET '    . $this->prepareUpdateSet($objectKeys)     .
                 ' WHERE '  . $this->id_key . '=:__update_id_unique_id';

        $statement = $this->connection->prepare($query);

        foreach($objectKeyAndValues as $key => $value){
            $objKey = ":" . $key;
            
            $statement->bindValue($objKey, $value);
        }

        $statement->bindValue(':__update_id_unique_id', $id);

        return $statement;
    }

    private function prepareUpdateSet(array $objectKeys): string{
        $updateSet = '';

        foreach($objectKeys as $key){
            $updateSet .= $key . '=' . ':' . $key . ',';
        }

        return substr($updateSet, 0, -1);
    }

    private function prepareDelete(string $id): PDOStatement{
        
        $query = ' DELETE FROM ' . $this->table                             .
                 ' WHERE '       . $this->id_key . '=:__update_id_unique_id';

        $statement = $this->connection->prepare($query);
        $statement->bindValue(':__update_id_unique_id', $id);

        return $statement;
    }
}