<?php

namespace RestExample\Tests;

class CotrollerTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function processGetRequest() {
    $resourceIdentifier = 1;
    $resourceRowData = '';
    $controller = $this->createControllerMock($resourceIdentifier, $resourceRowData, 'read');
    $controller->processRequest($this->createRequestStub(\RestExample\Server\iRequest::METHOD_GET, $resourceIdentifier,
                    $resourceRowData));
  }

  /**
   * @test
   */
  public function processPostRequest() {
    $resourceIdentifier = null;
    $resourceRowData = 'foo';
    $controller = $this->createControllerMock($resourceIdentifier, $resourceRowData, 'create');
    $controller->processRequest($this->createRequestStub(\RestExample\Server\iRequest::METHOD_POST, $resourceIdentifier,
                    $resourceRowData));
  }

  /**
   * @test
   */
  public function processPutRequest() {
    $resourceIdentifier = 1;
    $resourceRowData = 'foo';
    $controller = $this->createControllerMock($resourceIdentifier, $resourceRowData, 'update');
    $controller->processRequest($this->createRequestStub(\RestExample\Server\iRequest::METHOD_PUT, $resourceIdentifier,
                    $resourceRowData));
  }

  /**
   * @test
   */
  public function processDeleteRequest() {
    $resourceIdentifier = 1;
    $resourceRowData = '';
    $controller = $this->createControllerMock($resourceIdentifier, $resourceRowData, 'delete');
    $controller->processRequest($this->createRequestStub(\RestExample\Server\iRequest::METHOD_DELETE,
                    $resourceIdentifier, $resourceRowData));
  }

  /**
   * @param int $resourceIdentifier
   * @param string $resourceRowData
   * @param string $resourceManagerRequiredMethodName
   * @return \RestExample\Controller
   */
  private function createControllerMock($resourceIdentifier, $resourceRowData, $resourceManagerRequiredMethodName) {
    $resourceStub = $this->createResourceStub($resourceIdentifier);

    $resourceManagerMock = $this->getMockBuilder(\RestExample\Model\iCrud::class)->getMock();
    $resourceManagerMock->expects($this->once())
            ->method($resourceManagerRequiredMethodName)
            ->with($resourceStub);

    $dataMapperMock = $this->getMockBuilder(\RestExample\Model\iMapper::class)->getMock();
    $dataMapperMock->expects($this->once())
            ->method('dataToResource')
            ->with($this->equalTo($resourceIdentifier), $this->equalTo($resourceRowData))
            ->willReturn($resourceStub);

    $responseFake = $this->getMockBuilder(\RestExample\Server\iResponse::class)->getMock();

    $responseFactoryStub = $this->getMockBuilder(\RestExample\Server\Response\Factory::class)->getMock();
    $responseFactoryStub->method('createResponse')
            ->willReturn($responseFake);

    return new \RestExample\Controller($resourceManagerMock, $dataMapperMock, $responseFactoryStub);
  }

  /**
   * @param string $method
   * @param int $resourceIdentifier
   * @param string $rowData
   * @return \RestExample\Server\iRequest
   */
  private function createRequestStub($method, $resourceIdentifier, $rowData) {
    $stub = $this->getMockBuilder(\RestExample\Server\iRequest::class)->getMock();
    $stub->method('getMethod')->willReturn($method);
    $stub->method('getResourceName')->willReturn('foo');
    $stub->method('getResourceIdentifier')->willReturn($resourceIdentifier);
    $stub->method('getRawData')->willReturn($rowData);

    return $stub;
  }

  /**
   * @param int|null $identifier
   * @return \RestExample\Model\iResource
   */
  private function createResourceStub($identifier = null) {
    $stub = $this->getMockBuilder(\RestExample\Model\iResource::class)->getMock();
    $stub->method('getIdentifier')->willReturn($identifier);

    return $stub;
  }

}