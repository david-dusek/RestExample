<?php

namespace RestExample\Database;

interface iConnection {

  /**
   * @param string $resourceName
   * @param mixed[] $data
   * @return int;
   */
  public function insert($resourceName, array $data);

  /**
   * @param string $resourceName
   * @param int $identifier
   * @param mixed[] $data
   */
  public function update($resourceName, $identifier, array $data);

  /**
   * @param string $resourceName
   * @param int $identifier
   * @return mixed[]|false
   */
  public function find($resourceName, $identifier);

  /**
   * @param string $resourceName
   * @param int $identifier
   */
  public function delete($resourceName, $identifier);
}