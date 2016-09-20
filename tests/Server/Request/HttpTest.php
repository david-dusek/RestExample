<?php

namespace RestExample\Tests\Server\Request;

class HttpTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function getSourceNameIfIsSet() {
    $sourceName = 'test';
    $request = new \RestExample\Server\Request\Http("/$sourceName/123", \RestExample\Server\iRequest::METHOD_GET, '');
    $this->assertEquals($sourceName, $request->getSourceName());
  }

  /**
   * @test
   */
  public function getSourceNameIfIsEmpty() {
    $request = new \RestExample\Server\Request\Http("/", \RestExample\Server\iRequest::METHOD_GET, '');
    $this->assertEquals('', $request->getSourceName());
  }

  /**
   * @test
   */
  public function getSourceIdentifierIfIsSet() {
    $sourceIdentifier = 123;
    $request = new \RestExample\Server\Request\Http("/test/$sourceIdentifier", \RestExample\Server\iRequest::METHOD_GET,
            '');
    $this->assertEquals($sourceIdentifier, $request->getSourceIdentifier());
  }

  /**
   * @test
   */
  public function getSourceIdentifierIfIsNotSet() {
    $request = new \RestExample\Server\Request\Http("/test", \RestExample\Server\iRequest::METHOD_GET, '');
    $this->assertNull($request->getSourceIdentifier());
  }

  /**
   * @test
   */
  public function getSourceIdentifierIfIsNotNumeric() {
    $request = new \RestExample\Server\Request\Http("/test/foo", \RestExample\Server\iRequest::METHOD_GET, '');
    $this->assertNull($request->getSourceIdentifier());
  }

}