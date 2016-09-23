<?php

namespace RestExample\Tests\Model\Resource;

class UserTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function setIdentifierByConstructor() {
    $user = new \RestExample\Model\Resource\User(1);
    $this->assertSame(1, $user->getIdentifier());
  }

  /**
   * @test
   */
  public function setStringIdentifierByConstructor() {
    $user = new \RestExample\Model\Resource\User('1');
    $this->assertSame(1, $user->getIdentifier());
  }

  /**
   * @test
   */
  public function setIdentifierBySetter() {
    $user = new \RestExample\Model\Resource\User();
    $user->setIdentifer(1);
    $this->assertSame(1, $user->getIdentifier());
  }

  /**
   * @test
   * @expectedException \RestExample\Model\Exception\Immutable
   */
  public function changeResourceIdentifier() {
    $user = new \RestExample\Model\Resource\User(1);
    $user->setIdentifer(2);
  }

}