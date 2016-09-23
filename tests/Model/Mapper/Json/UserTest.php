<?php

namespace RestExample\Tests\Model\Mapper\Json;

class UserTest extends \PHPUnit_Framework_TestCase {

  private $mapper;

  protected function setUp() {
    $this->mapper = new \RestExample\Model\Mapper\Json\User();
  }

  /**
   * @test
   * @dataProvider dataToResourceProvider
   *
   * @param int $identifier
   * @param string $data
   * @param \RestExample\Model\Resource\iUser $user
   */
  public function dataToResource($identifier, $data, \RestExample\Model\Resource\iUser $user) {
    $this->assertEquals($user, $this->mapper->dataToResource($identifier, $data));
  }

  /**
   * @test
   * @expectedException \RestExample\Model\Exception\InvalidJson
   */
  public function dataToResourceWithInvalidJson() {
    $this->mapper->dataToResource(null, "{'foo':bar}");
  }

  /**
   * @return mixed
   */
  public function dataToResourceProvider() {
    $userResource1 = new \RestExample\Model\Resource\User();
    $userResource1->setFirstname('Foo');
    $userResource1->setSurname('Bar');

    $userObject1 = new \stdClass();
    $userObject1->firstname = 'Foo';
    $userObject1->surname = 'Bar';

    $userResource2 = new \RestExample\Model\Resource\User(2);
    $userResource2->setFirstname('Baz');

    $userObject2 = new \stdClass();
    $userObject2->firstname = 'Baz';

    return [
      [null, \json_encode($userObject1), $userResource1],
      [2, \json_encode($userObject2), $userResource2],
    ];
  }

  /**
   * @test
   * @dataProvider resourceToDataProvider
   */
  public function resourceToData(\RestExample\Model\Resource\iUser $user, $data) {
    $this->assertEquals($data, $this->mapper->resourceToData($user));
  }

  /**
   * @return mixed
   */
  public function resourceToDataProvider() {
    $userResource1 = new \RestExample\Model\Resource\User();
    $userResource1->setFirstname('Foo');
    $userResource1->setSurname('Bar');

    $userObject1 = new \stdClass();
    $userObject1->firstname = 'Foo';
    $userObject1->surname = 'Bar';

    $userResource2 = new \RestExample\Model\Resource\User(2);
    $userResource2->setFirstname('Baz');

    $userObject2 = new \stdClass();
    $userObject2->identifier = 2;
    $userObject2->firstname = 'Baz';

    return [
      [$userResource1, \json_encode($userObject1)],
      [$userResource2, \json_encode($userObject2)],
    ];
  }

}