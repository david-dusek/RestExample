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
   * @return \RestExample\iController
   * @throws \RestExample\Model\Exception\ResourceManagerNotImplemented
   * @throws \RestExample\Model\Exception\DataMapperNotImplemented
   */
  public function createByResourceIdentifier($resourceIdentifier) {
    return new \RestExample\Controller($this->createResourceManagerByResourceIdentifier($resourceIdentifier),
            $this->createDataMapperByResourceIdentifier($resourceIdentifier), $this->responseFactory);
  }

  /**
   * @todo Detach to Resource Manager factory and inject it in constructor.
   *
   * @param string $resourceIdentifier
   * @return \RestExample\Controller\sourceManagerClass
   * @throws \RestExample\Model\Exception\ResourceManagerNotImplemented
   */
  private function createResourceManagerByResourceIdentifier($resourceIdentifier) {
    $resourceManagerClass = '\\RestExample\\Model\\Resource\\' . \ucfirst($resourceIdentifier) . 'Manager';
    if (!\class_exists($resourceManagerClass)) {
      throw new \RestExample\Model\Exception\ResourceManagerNotImplemented("Resource manager for resource $resourceIdentifier not implemented.");
    }

    return new $resourceManagerClass($this->databaseConnection);
  }

  /**
   * @todo Detach to Data Mapper factory and inject it in constructor.
   *
   * @param string $resourceIdentifier
   * @return \RestExample\Controller\dataMapperClass
   * @throws \RestExample\Model\Exception\DataMapperNotImplemented
   */
  private function createDataMapperByResourceIdentifier($resourceIdentifier) {
    $dataMapperClass = '\\RestExample\\Model\\Mapper\\Json\\' . \ucfirst($resourceIdentifier);
    if (!\class_exists($dataMapperClass)) {
      throw new \RestExample\Model\Exception\DataMapperNotImplemented("Data mapper for resource $resourceIdentifier not implemented.");
    }

    return new $dataMapperClass();
  }

}