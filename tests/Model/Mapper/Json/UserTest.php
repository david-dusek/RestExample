<?php

namespace RestExample\Tests\Model\Mapper\Json;

class UserTest extends \PHPUnit_Framework_TestCase {

  private $mapper;

  protected function setUp() {
    $this->mapper = new \RestExample\Model\Mapper\Json\User();
  }

  /**
   * @test
   * @dataProvider dataToSourceProvider
   *
   * @param int $identifier
   * @param string $data
   * @param \RestExample\Model\Source\iUser $user
   */
  public function dataToSource($identifier, $data, \RestExample\Model\Source\iUser $user) {
    $this->assertEquals($user, $this->mapper->dataToSource($identifier, $data));
  }

  /**
   * @test
   * @expectedException \RestExample\Model\Exception\InvalidJson
   */
  public function dataToSourceWithInvalidJson() {
    $this->mapper->dataToSource(null, "{'foo':bar}");
  }

  /**
   * @return mixed
   */
  public function dataToSourceProvider() {
    $userSource1 = new \RestExample\Model\Source\User();
    $userSource1->setFirstname('Foo');
    $userSource1->setSurname('Bar');

    $userObject1 = new \stdClass();
    $userObject1->firstname = 'Foo';
    $userObject1->surname = 'Bar';

    $userSource2 = new \RestExample\Model\Source\User(2);
    $userSource2->setFirstname('Baz');

    $userObject2 = new \stdClass();
    $userObject2->firstname = 'Baz';

    return [
      [null, \json_encode($userObject1), $userSource1],
      [2, \json_encode($userObject2), $userSource2],
    ];
  }

  /**
   * @test
   * @dataProvider sourceToDataProvider
   */
  public function sourceToData(\RestExample\Model\Source\iUser $user, $data) {
    $this->assertEquals($data, $this->mapper->sourceToData($user));
  }

  /**
   * @return mixed
   */
  public function sourceToDataProvider() {
    $userSource1 = new \RestExample\Model\Source\User();
    $userSource1->setFirstname('Foo');
    $userSource1->setSurname('Bar');

    $userObject1 = new \stdClass();
    $userObject1->firstname = 'Foo';
    $userObject1->surname = 'Bar';

    $userSource2 = new \RestExample\Model\Source\User(2);
    $userSource2->setFirstname('Baz');

    $userObject2 = new \stdClass();
    $userObject2->identifier = 2;
    $userObject2->firstname = 'Baz';

    return [
      [$userSource1, \json_encode($userObject1)],
      [$userSource2, \json_encode($userObject2)],
    ];
  }

}