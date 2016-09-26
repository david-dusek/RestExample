<?php

namespace RestExample\Tests\Controller;

class FactoryTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function createUserController() {
    $databaseConnectionFake = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $responseFactoryFake = $this->getMockBuilder(\RestExample\Server\Response\Factory::class)->getMock();
    $factory = new \RestExample\Controller\Factory($databaseConnectionFake, $responseFactoryFake);
    $this->assertInstanceOf(\RestExample\iController::class, $factory->createByResourceIdentifier('user'));
  }

}