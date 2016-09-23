<?php

namespace RestExample\Tests\Server\Request;

class HttpTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function getResourceNameIfIsSet() {
    $resourceName = 'test';
    $request = new \RestExample\Server\Request\Http("/$resourceName/123", \RestExample\Server\iRequest::METHOD_GET, '');
    $this->assertEquals($resourceName, $request->getResourceName());
  }

  /**
   * @test
   */
  public function getResourceNameIfIsEmpty() {
    $request = new \RestExample\Server\Request\Http("/", \RestExample\Server\iRequest::METHOD_GET, '');
    $this->assertEquals('', $request->getResourceName());
  }

  /**
   * @test
   */
  public function getResourceIdentifierIfIsSet() {
    $resourceIdentifier = 123;
    $request = new \RestExample\Server\Request\Http("/test/$resourceIdentifier", \RestExample\Server\iRequest::METHOD_GET,
            '');
    $this->assertEquals($resourceIdentifier, $request->getResourceIdentifier());
  }

  /**
   * @test
   */
  public function getResourceIdentifierIfIsNotSet() {
    $request = new \RestExample\Server\Request\Http("/test", \RestExample\Server\iRequest::METHOD_GET, '');
    $this->assertNull($request->getResourceIdentifier());
  }

  /**
   * @test
   */
  public function getResourceIdentifierIfIsNotNumeric() {
    $request = new \RestExample\Server\Request\Http("/test/foo", \RestExample\Server\iRequest::METHOD_GET, '');
    $this->assertNull($request->getResourceIdentifier());
  }

}