<?php

namespace RestExample\Tests;

class CotrollerTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function processGetRequest() {
    $sourceIdentifier = 1;
    $sourceRowData = '';
    $controller = $this->createControllerMock($sourceIdentifier, $sourceRowData, 'read');
    $controller->processRequest($this->createRequestStub(\RestExample\Server\iRequest::METHOD_GET, $sourceIdentifier,
                    $sourceRowData));
  }

  /**
   * @test
   */
  public function processPostRequest() {
    $sourceIdentifier = null;
    $sourceRowData = 'foo';
    $controller = $this->createControllerMock($sourceIdentifier, $sourceRowData, 'create');
    $controller->processRequest($this->createRequestStub(\RestExample\Server\iRequest::METHOD_POST, $sourceIdentifier,
                    $sourceRowData));
  }

  /**
   * @test
   */
  public function processPutRequest() {
    $sourceIdentifier = 1;
    $sourceRowData = 'foo';
    $controller = $this->createControllerMock($sourceIdentifier, $sourceRowData, 'update');
    $controller->processRequest($this->createRequestStub(\RestExample\Server\iRequest::METHOD_PUT, $sourceIdentifier,
                    $sourceRowData));
  }

  /**
   * @test
   */
  public function processDeleteRequest() {
    $sourceIdentifier = 1;
    $sourceRowData = '';
    $controller = $this->createControllerMock($sourceIdentifier, $sourceRowData, 'delete');
    $controller->processRequest($this->createRequestStub(\RestExample\Server\iRequest::METHOD_DELETE, $sourceIdentifier,
                    $sourceRowData));
  }

  /**
   * @test
   * @expectedException \RestExample\Controller\Exception\UnsupportedMethod
   */
  public function processNotExistingMethodRequest() {
    $sourceManagerFake = $this->getMockBuilder(\RestExample\Model\iCrud::class)->getMock();
    $dataMapperFake = $this->getMockBuilder(\RestExample\Model\iMapper::class)->getMock();
    $controller = new \RestExample\Controller($sourceManagerFake, $dataMapperFake);
    $controller->processRequest($this->createRequestStub('FOO', 1, ''));
  }

  /**
   * @param int $sourceIdentifier
   * @param string $sourceRowData
   * @param string $sourceManagerRequiredMethodName
   * @return \RestExample\Controller
   */
  private function createControllerMock($sourceIdentifier, $sourceRowData, $sourceManagerRequiredMethodName) {
    $sourceStub = $this->createSourceStub($sourceIdentifier);

    $sourceManagerMock = $this->getMockBuilder(\RestExample\Model\iCrud::class)->getMock();
    $sourceManagerMock->expects($this->once())
            ->method($sourceManagerRequiredMethodName)
            ->with($sourceStub);

    $dataMapperMock = $this->getMockBuilder(\RestExample\Model\iMapper::class)->getMock();
    $dataMapperMock->expects($this->once())
            ->method('dataToSource')
            ->with($this->equalTo($sourceIdentifier), $this->equalTo($sourceRowData))
            ->willReturn($sourceStub);

    return new \RestExample\Controller($sourceManagerMock, $dataMapperMock);
  }

  /**
   * @param string $method
   * @param int $sourceIdentifier
   * @param string $rowData
   * @return \RestExample\Server\iRequest
   */
  private function createRequestStub($method, $sourceIdentifier, $rowData) {
    $stub = $this->getMockBuilder(\RestExample\Server\iRequest::class)->getMock();
    $stub->method('getMethod')->willReturn($method);
    $stub->method('getSourceName')->willReturn('foo');
    $stub->method('getSourceIdentifier')->willReturn($sourceIdentifier);
    $stub->method('getRawData')->willReturn($rowData);

    return $stub;
  }

  /**
   * @param int|null $identifier
   * @return \RestExample\Model\iSource
   */
  private function createSourceStub($identifier = null) {
    $stub = $this->getMockBuilder(\RestExample\Model\iSource::class)->getMock();
    $stub->method('getIdentifier')->willReturn($identifier);

    return $stub;
  }

}