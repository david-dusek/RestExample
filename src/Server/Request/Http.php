<?php

namespace RestExample\Server\Request;

class Http implements \RestExample\Server\iRequest {

  /**
   * @var string
   */
  private $uri;

  /**
   * @var string
   */
  private $method;

  /**
   * @var mixed[]
   */
  private $rawData;

  /**
   * @param string $uri
   * @param string $method
   * @param string $rawData
   */
  public function __construct($uri, $method, $rawData) {
    $this->uri = $uri;
    $this->method = $method;
    $this->rawData = $rawData;
  }

  /**
   * @return \RestExample\Server\Request
   */
  public static function createFromGlobals() {
    return new \RestExample\Server\Request\Http(\filter_input(\INPUT_SERVER, 'REQUEST_URI'),
            \filter_input(\INPUT_SERVER, 'REQUEST_METHOD'), \file_get_contents('php://input'));
  }

  /**
   * @return string|null
   */
  public function getResourceName() {
    $uriParts = $this->getUriParts();

    return !empty($uriParts) ? (string) \reset($uriParts) : null;
  }

  /**
   * @return int|null
   */
  public function getResourceIdentifier() {
    $uriParts = $this->getUriParts();

    return \count($uriParts) > 1 && \is_numeric($uriParts[1]) ? (int) $uriParts[1] : null;
  }

  /**
   * @return string Returns one of \RestExample\Server\iRequest::METHOD_*
   */
  public function getMethod() {
    return $this->method;
  }

  /**
   * @return string
   */
  public function getRawData() {
    return $this->rawData;
  }

  /**
   * @return string[]
   */
  private function getUriParts() {
    return \explode('/', \trim($this->uri, '/'));
  }

}