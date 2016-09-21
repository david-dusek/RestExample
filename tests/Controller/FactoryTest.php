<?php

namespace RestExample\Tests\Controller;

class FactoryTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function createUserController() {
    $databaseConnectionFake = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $factory = new \RestExample\Controller\Factory($databaseConnectionFake);
    $this->assertInstanceOf(\RestExample\iController::class, $factory->createBySourceIdentifier('user'));
  }

}