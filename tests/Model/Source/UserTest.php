<?php

namespace RestExample\Tests\Model\Source;

class UserTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function setIdentifierByConstructor() {
    $user = new \RestExample\Model\Source\User(1);
    $this->assertSame(1, $user->getIdentifier());
  }

  /**
   * @test
   */
  public function setStringIdentifierByConstructor() {
    $user = new \RestExample\Model\Source\User('1');
    $this->assertSame(1, $user->getIdentifier());
  }

  /**
   * @test
   */
  public function setIdentifierBySetter() {
    $user = new \RestExample\Model\Source\User();
    $user->setIdentifer(1);
    $this->assertSame(1, $user->getIdentifier());
  }

  /**
   * @test
   * @expectedException \RestExample\Model\Exception\Immutable
   */
  public function changeSourceIdentifier() {
    $user = new \RestExample\Model\Source\User(1);
    $user->setIdentifer(2);
  }

}