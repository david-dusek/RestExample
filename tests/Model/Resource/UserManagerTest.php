<?php

namespace RestExample\Tests\Model\Resource;

class UserManagerTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function create() {
    $identifier = 1;
    $data = [
      'firstname' => 'foo',
      'surname' => 'bar'
    ];

    $databaseConnectionMock = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $databaseConnectionMock->expects($this->once())
            ->method('insert')
            ->with($this->equalTo('user'), $this->equalTo($data))
            ->willReturn($identifier);

    $resourceMock = $this->getMockBuilder(\RestExample\Model\Resource\iUser::class)->getMock();
    $resourceMock->expects($this->once())
            ->method('getData')
            ->willReturn($data);
    $resourceMock->expects($this->once())
            ->method('setIdentifer')
            ->with($this->equalTo($identifier));

    $userManager = new \RestExample\Model\Resource\UserManager($databaseConnectionMock);
    $userManager->create($resourceMock);
  }

  /**
   * @test
   * @expectedException \RestExample\Model\Exception\InvalidResourceType
   */
  public function createWithInvalidResource() {
    $resourceFake = $this->getMockBuilder(\RestExample\Model\iResource::class)->getMock();
    $databaseConnectionFake = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $userManager = new \RestExample\Model\Resource\UserManager($databaseConnectionFake);
    $userManager->create($resourceFake);
  }

  /**
   * @test
   */
  public function read() {
    $identifier = 1;
    $firstname = 'foo';
    $surname = 'bar';
    $data = [
      'firstname' => $firstname,
      'surname' => $surname,
    ];

    $databaseConnectionMock = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $databaseConnectionMock->expects($this->once())
            ->method('find')
            ->with($this->equalTo('user'), $this->equalTo($identifier))
            ->willReturn($data);

    $resourceMock = $this->getMockBuilder(\RestExample\Model\Resource\iUser::class)->getMock();
    $resourceMock->expects($this->once())
            ->method('getIdentifier')
            ->willReturn($identifier);
    $resourceMock->expects($this->once())
            ->method('setFirstname')
            ->with($this->equalTo($firstname));
    $resourceMock->expects($this->once())
            ->method('setSurname')
            ->with($this->equalTo($surname));

    $userManager = new \RestExample\Model\Resource\UserManager($databaseConnectionMock);
    $userManager->read($resourceMock);
  }

  /**
   * @test
   */
  public function readAndNotFound() {
    $identifier = 1;
    $data = false;

    $databaseConnectionMock = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $databaseConnectionMock->expects($this->once())
            ->method('find')
            ->with($this->equalTo('user'), $this->equalTo($identifier))
            ->willReturn($data);

    $resourceMock = $this->getMockBuilder(\RestExample\Model\Resource\iUser::class)->getMock();
    $resourceMock->expects($this->once())
            ->method('getIdentifier')
            ->willReturn($identifier);
    $resourceMock->expects($this->once())
            ->method('setEmptyObject')
            ->with($this->equalTo(true));

    $userManager = new \RestExample\Model\Resource\UserManager($databaseConnectionMock);
    $userManager->read($resourceMock);
  }

  /**
   * @test
   * @expectedException \RestExample\Model\Exception\InvalidResourceType
   */
  public function readWithInvalidResource() {
    $resourceFake = $this->getMockBuilder(\RestExample\Model\iResource::class)->getMock();
    $databaseConnectionFake = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $userManager = new \RestExample\Model\Resource\UserManager($databaseConnectionFake);
    $userManager->read($resourceFake);
  }

  /**
   * @test
   */
  public function update() {
    $identifier = 1;
    $firstname = 'foo';
    $surname = 'bar';
    $data = [
      'firstname' => $firstname,
      'surname' => $surname,
    ];

    $databaseConnectionMock = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $databaseConnectionMock->expects($this->once())
            ->method('update')
            ->with($this->equalTo('user'), $this->equalTo($identifier), $this->equalTo($data))
            ->willReturn($data);

    $resourceMock = $this->getMockBuilder(\RestExample\Model\Resource\iUser::class)->getMock();
    $resourceMock->expects($this->once())
            ->method('getIdentifier')
            ->willReturn($identifier);
    $resourceMock->expects($this->once())
            ->method('getData')
            ->willReturn($data);

    $userManager = new \RestExample\Model\Resource\UserManager($databaseConnectionMock);
    $userManager->update($resourceMock);
  }

  /**
   * @test
   * @expectedException \RestExample\Model\Exception\InvalidResourceType
   */
  public function updateWithInvalidResource() {
    $resourceFake = $this->getMockBuilder(\RestExample\Model\iResource::class)->getMock();
    $databaseConnectionFake = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $userManager = new \RestExample\Model\Resource\UserManager($databaseConnectionFake);
    $userManager->update($resourceFake);
  }

  /**
   * @test
   */
  public function delete() {
    $identifier = 1;

    $databaseConnectionMock = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $databaseConnectionMock->expects($this->once())
            ->method('delete')
            ->with($this->equalTo('user'), $this->equalTo($identifier));

    $resourceMock = $this->getMockBuilder(\RestExample\Model\Resource\iUser::class)->getMock();
    $resourceMock->expects($this->once())
            ->method('getIdentifier')
            ->willReturn($identifier);

    $userManager = new \RestExample\Model\Resource\UserManager($databaseConnectionMock);
    $userManager->delete($resourceMock);
  }

  /**
   * @test
   * @expectedException \RestExample\Model\Exception\InvalidResourceType
   */
  public function deleteWithInvalidResource() {
    $resourceFake = $this->getMockBuilder(\RestExample\Model\iResource::class)->getMock();
    $databaseConnectionFake = $this->getMockBuilder(\RestExample\Database\iConnection::class)->getMock();
    $userManager = new \RestExample\Model\Resource\UserManager($databaseConnectionFake);
    $userManager->delete($resourceFake);
  }

}