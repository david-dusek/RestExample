<?php

namespace RestExample\Tests\Config;

class JsonFileTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   * @expectedException \RestExample\Config\Exception\BadFilename
   */
  public function badFilename() {
    new \RestExample\Config\JsonFile(__DIR__ . \DIRECTORY_SEPARATOR . 'foo.json');
  }

  /**
   * @test
   */
  public function getDatabaseConfig() {
    $config = new \RestExample\Config\JsonFile($this->getTestConfigFilename());
    $this->assertEquals('test', $config->getDatabaseConnectionDsn());
    $this->assertEquals('username', $config->getDatabaseConnectionUsername());
    $this->assertEquals('password', $config->getDatabaseConnectionPassword());
  }

  /**
   * @return string
   */
  private function getTestConfigFilename() {
    return __DIR__ . \DIRECTORY_SEPARATOR . 'config.json';
  }

}