<?php

namespace RestExample\Database;

class Factory {

  /**
   * @return \RestExample\Database\MySql
   */
  public function createMySqlConnectionByConfig() {
    $config = new \RestExample\Config\JsonFile(__DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . '..'
            . \DIRECTORY_SEPARATOR . 'config' . \DIRECTORY_SEPARATOR . 'config.json');

    return new \RestExample\Database\MySql(new \PDO($config->getDatabaseConnectionDsn(),
            $config->getDatabaseConnectionUsername(), $config->getDatabaseConnectionPassword()));
  }

}