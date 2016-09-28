<?php

namespace RestExample;

class Application {

  /**
   * @var \RestExample\Database\iConnection
   */
  private $databaseConnection;

  /**
   * @var \RestExample\Server\Response\Factory
   */
  private $responseFactory;

  public function __construct() {
    $this->init();
  }

  private function init() {
    $databaseFactory = new \RestExample\Database\Factory();
    $this->databaseConnection = $databaseFactory->createMySqlConnectionByConfig();
    $this->responseFactory = new \RestExample\Server\Response\Factory();
  }

  public function run() {
    $request = \RestExample\Server\Request\Http::createFromGlobals();
    $response = $this->processRequest($request);
    $response->send();
  }

  /**
   * @param \RestExample\Server\iRequest $request
   * @return \RestExample\Server\iResponse
   */
  private function processRequest(\RestExample\Server\iRequest $request) {
    $controllerFactory = new \RestExample\Controller\Factory($this->databaseConnection, $this->responseFactory);
    $controller = $controllerFactory->createByResourceName($request->getResourceName());
    if (\is_null($controller)) {
      $response = $this->responseFactory->createResponse();
      $response->setStatusCode(\RestExample\Server\iResponse::CODE_NOT_FOUND);
      return $response;
    }

    return $controller->processRequest($request);
  }

}