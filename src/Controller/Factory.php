<?php

namespace RestExample\Controller;

class Factory {

  /**
   * @var \RestExample\Database\iConnection
   */
  private $databaseConnection;

  /**
   * @var \RestExample\Server\Response\Factory
   */
  private $responseFactory;

  /**
   * @param \RestExample\Database\iConnection $databaseConnection
   * @param \RestExample\Server\Response\Factory $responseFactory
   */
  public function __construct(\RestExample\Database\iConnection $databaseConnection,
                              \RestExample\Server\Response\Factory $responseFactory) {
    $this->databaseConnection = $databaseConnection;
    $this->responseFactory = $responseFactory;
  }

  /**
   * @param string $resourceIdentifier
   * @return \RestExample\iController|null
   */
  public function createByResourceName($resourceIdentifier) {
    $resourceManager = $this->createResourceManagerByResourceIdentifier($resourceIdentifier);
    $dataMapper = $this->createDataMapperByResourceIdentifier($resourceIdentifier);

    if (\is_null($resourceManager) || \is_null($dataMapper)) {
      return null;
    }

    return new \RestExample\Controller($resourceManager, $dataMapper, $this->responseFactory);
  }

  /**
   * @todo Detach to Resource Manager factory and inject it in constructor.
   *
   * @param string $resourceIdentifier
   * @return \RestExample\Controller\sourceManagerClass|null
   */
  private function createResourceManagerByResourceIdentifier($resourceIdentifier) {
    $resourceManagerClass = '\\RestExample\\Model\\Resource\\' . \ucfirst($resourceIdentifier) . 'Manager';
    if (!\class_exists($resourceManagerClass)) {
      return null;
    }

    return new $resourceManagerClass($this->databaseConnection);
  }

  /**
   * @todo Detach to Data Mapper factory and inject it in constructor.
   *
   * @param string $resourceIdentifier
   * @return \RestExample\Controller\dataMapperClass|null
   */
  private function createDataMapperByResourceIdentifier($resourceIdentifier) {
    $dataMapperClass = '\\RestExample\\Model\\Mapper\\Json\\' . \ucfirst($resourceIdentifier);
    if (!\class_exists($dataMapperClass)) {
      return null;
    }

    return new $dataMapperClass();
  }

}