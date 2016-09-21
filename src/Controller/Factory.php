<?php

namespace RestExample\Controller;

class Factory {

  /**
   * @var \RestExample\Database\iConnection
   */
  private $databaseConnection;

  /**
   * @param \RestExample\Database\iConnection $databaseConnection
   */
  public function __construct(\RestExample\Database\iConnection $databaseConnection) {
    $this->databaseConnection = $databaseConnection;
  }

  /**
   * @param string $sourceIdentifier
   * @return \RestExample\iController
   * @throws \RestExample\Model\Exception\SourceManagerNotImplemented
   * @throws \RestExample\Model\Exception\DataMapperNotImplemented
   */
  public function createBySourceIdentifier($sourceIdentifier) {
    return new \RestExample\Controller($this->createSourceManagerBySourceIdentifier($sourceIdentifier),
            $this->createDataMapperBySourceIdentifier($sourceIdentifier));
  }

  /**
   * @todo Detach to Source Manager factory and inject it in constructor.
   * 
   * @param string $sourceIdentifier
   * @return \RestExample\Controller\sourceManagerClass
   * @throws \RestExample\Model\Exception\SourceManagerNotImplemented
   */
  private function createSourceManagerBySourceIdentifier($sourceIdentifier) {
    $sourceManagerClass = '\\RestExample\\Model\\Source\\' . \ucfirst($sourceIdentifier) . 'Manager';
    if (!\class_exists($sourceManagerClass)) {
      throw new \RestExample\Model\Exception\SourceManagerNotImplemented("Source manager for source $sourceIdentifier not implemented.");
    }

    return new $sourceManagerClass($this->databaseConnection);
  }

  /**
   * @todo Detach to Data Mapper factory and inject it in constructor.
   *
   * @param string $sourceIdentifier
   * @return \RestExample\Controller\dataMapperClass
   * @throws \RestExample\Model\Exception\DataMapperNotImplemented
   */
  private function createDataMapperBySourceIdentifier($sourceIdentifier) {
    $dataMapperClass = '\\RestExample\\Model\\Mapper\\Json\\' . \ucfirst($sourceIdentifier);
    if (!\class_exists($dataMapperClass)) {
      throw new \RestExample\Model\Exception\DataMapperNotImplemented("Data mapper for source $sourceIdentifier not implemented.");
    }

    return new $dataMapperClass();
  }

}