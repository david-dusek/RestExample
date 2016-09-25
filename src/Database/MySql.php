<?php

namespace RestExample\Database;

class MySql implements \RestExample\Database\iConnection {

  /**
   * @var \PDO
   */
  private $pdo;

  /**
   * @param \PDO $pdo
   */
  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  /**
   * @param string $resourceName
   * @param mixed[] $data
   * @return int
   */
  public function insert($resourceName, array $data) {
    $tableName = $this->resourceNameToTableName($resourceName);
    $columnsPart = \implode(',', \array_keys($data));
    $valuesPart = \trim(\str_repeat('?,', \count($data)), ',');

    $insertStatement = $this->pdo->prepare("INSERT INTO $tableName ($columnsPart) VALUES ($valuesPart)");
    if ($insertStatement->execute(\array_values($data)) === true) {
      return $this->pdo->lastInsertId();
    } else {
      throw new \RestExample\Database\Exception\InsertQueryFail("Insert $resourceName failed");
    }
  }

  /**
   * @param string $resourceName
   * @param int $identifier
   * @param mixed[] $data
   */
  public function update($resourceName, $identifier, array $data) {
    $tableName = $this->resourceNameToTableName($resourceName);
    $identifierColumnName = $this->resourceNameToColumnName($resourceName);
    $setPart = \implode('=?,', \array_keys($data)) . '=?';

    $updateStatement = $this->pdo->prepare("UPDATE $tableName SET $setPart WHERE $identifierColumnName=?");

    $values = \array_values($data);
    \array_push($values, $identifier);

    if ($updateStatement->execute($values) === false) {
      throw new \RestExample\Database\Exception\UpdateQueryFail("Update $resourceName with identifier $identifier failed");
    }
  }

  /**
   * @param string $resourceName
   * @param int $identifier
   * @return mixed[]|false
   */
  public function find($resourceName, $identifier) {
    $tableName = $this->resourceNameToTableName($resourceName);
    $identifierColumnName = $this->resourceNameToColumnName($resourceName);

    $updateStatement = $this->pdo->prepare("SELECT * FROM $tableName WHERE $identifierColumnName=?");
    if ($updateStatement->execute([$identifier]) === false) {
      throw new \RestExample\Database\Exception\FindQueryFail("Search $resourceName with identifier $identifier failed");
    }

    return $updateStatement->fetch(\pdo::FETCH_ASSOC);
  }

  /**
   * @param string $resourceName
   * @param int $identifier
   */
  public function delete($resourceName, $identifier) {
    $tableName = $this->resourceNameToTableName($resourceName);
    $identifierColumnName = $this->resourceNameToColumnName($resourceName);

    $updateStatement = $this->pdo->prepare("DELETE $tableName WHERE $identifierColumnName=?");
    if ($updateStatement->execute([$identifier]) === false) {
      throw new \RestExample\Database\Exception\DeleteQueryFail("Delete $resourceName with identifier $identifier failed");
    }
  }

  /**
   * @param string $resourceName
   * @return string
   */
  private function resourceNameToTableName($resourceName) {
    return $resourceName . '_resources';
  }

  /**
   * @param string $resourceName
   * @return type
   */
  private function resourceNameToColumnName($resourceName) {
    return 'id_' . $resourceName;
  }

}