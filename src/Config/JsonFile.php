<?php

namespace RestExample\Config;

class JsonFile implements \RestExample\Config\iDatabaseConnection {

  /**
   * @var string
   */
  private $databaseConnectionDsn;

  /**
   * @var string
   */
  private $databaseConnectionPassword;

  /**
   * @var string
   */
  private $databaseConnectionUsername;

  /**
   * @param string $filename
   */
  public function __construct($filename = null) {
    $this->checkFilename($filename);
    $this->loadFile($filename);
  }

  /**
   * @param string $filename
   * @throws \RestExample\Config\Exception\BadFilename
   */
  private function checkFilename($filename) {
    if (!\file_exists($filename) || (file_exists($filename) && !\is_readable($filename))) {
      throw new \RestExample\Config\Exception\BadFilename("File $filename not exist or is not readable");
    }
  }

  /**
   * @param string $filename
   */
  private function loadFile($filename) {
    $configFileContentJson = \file_get_contents($filename);
    if ($configFileContentJson === false) {
      throw new \RestExample\Config\Exception\BadFilename("Unable to get content of file $filename");
    }

    $config = \json_decode($configFileContentJson);

    $this->databaseConnectionDsn = $config->database->dsn;
    $this->databaseConnectionUsername = $config->database->username;
    $this->databaseConnectionPassword = $config->database->password;
  }

  /**
   * @return string
   */
  public function getDatabaseConnectionDsn() {
    return $this->databaseConnectionDsn;
  }

  /**
   * @return string
   */
  public function getDatabaseConnectionPassword() {
    return $this->databaseConnectionPassword;
  }

  /**
   * @return string
   */
  public function getDatabaseConnectionUsername() {
    return $this->databaseConnectionUsername;
  }

}