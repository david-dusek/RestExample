<?php

namespace RestExample\Tests\Controller;

class FactoryTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var \RestExample\Controller\Factory
   */
  private $factory;

  protected function setUp() {
    $databaseConnectionFake = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $responseFactoryFake = $this->getMockBuilder(\RestExample\Server\Response\Factory::class)->getMock();
    $this->factory = new \RestExample\Controller\Factory($databaseConnectionFake, $responseFactoryFake);
  }

  /**
   * @test
   */
  public function createUserController() {
    $this->assertInstanceOf(\RestExample\iController::class, $this->factory->createByResourceName('user'));
  }

  /**
   * @test
   */
  public function createUndefinedController() {
    $this->assertNull($this->factory->createByResourceName('foo'));
  }

}