<?php

namespace RestExample\Model\Resource;

class UserManager implements \RestExample\Model\iCrud {

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
   * @return string
   */
  private function getResourceName() {
    return 'user';
  }

  /**
   * @param \RestExample\Model\iResource $resource
   */
  public function create(\RestExample\Model\iResource $resource) {
    $this->checkResourceType($resource);
    $identifier = $this->databaseConnection->insert($this->getResourceName(), $resource->getData());
    $resource->setIdentifer($identifier);
  }

  /**
   * @param \RestExample\Model\iResource $resource
   */
  public function read(\RestExample\Model\iResource $resource) {
    $this->checkResourceType($resource);
    $data = $this->databaseConnection->find($this->getResourceName(), $resource->getIdentifier());
    if ($data === false) {
      $resource->setEmptyObject(true);
    } else {
      $resource->setFirstname(isset($data['firstname']) ? $data['firstname'] : null);
      $resource->setSurname(isset($data['surname']) ? $data['surname'] : null);
    }
  }

  /**
   * @param \RestExample\Model\iResource $resource
   */
  public function update(\RestExample\Model\iResource $resource) {
    $this->checkResourceType($resource);
    $this->databaseConnection->update($this->getResourceName(), $resource->getIdentifier(), $resource->getData());
  }

  /**
   * @param \RestExample\Model\iResource $resource
   */
  public function delete(\RestExample\Model\iResource $resource) {
    $this->checkResourceType($resource);
    $this->databaseConnection->delete($this->getResourceName(), $resource->getIdentifier());
  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @throws \RestExample\Model\Exception\InvalidResourceType
   */
  private function checkResourceType(\RestExample\Model\iResource $resource) {
    if (!($resource instanceof \RestExample\Model\Resource\iUser)) {
      throw new \RestExample\Model\Exception\InvalidResourceType('Expecting resource of type '
      . \RestExample\Model\Resource\iUser::class . ', ' . \get_class($resource) . ' given');
    }
  }

}