<?php 

namespace Rangel\Tcc\Repository;

interface IRepository {

    /**
     * Obtém o último ID inserido na tabela
     * @return string id
     */
    public function getLastInsertedId(): string;

    public function getTableCount(): int;

    /**
     * Procura por um registro na tabela por id
     * @param string $id
     * @return object Caso encontre, retorna um objeto com os atributos do registro
     */
    public function findById(string $id): array;

    /**
     * Retorna os registros da tabela de forma paginada
     * @param integer $limit a quantidade máxima de registros retornados
     * @param integer $offset a partir de qual registro deve ser retornado
     */
    public function list(int $limit, int $offset): array;

    /**
     * Salva um registro na tabela a partir do nome dos campos do objeto (devem ser iguais aos nomes das colunas na tabela)
     * @param object $object Objeto a salvar no banco
     */
    public function save(object $object): void;

    /**
     * Deleta um registro da tabela
     * @param integer $id id do registro
     */
    public function delete(int $id): void;

    /**
     * Atualiza um registro na tabela, campos nulos são desconsiderados na atualização
     * @param integer $id id do registro
     * @param object $object Objeto com os campos atualizados
     */
    public function update(int $id, object $object): void;

}