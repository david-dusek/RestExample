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
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Model\iResource
   */
  public function create(\RestExample\Model\iResource $resource) {

  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Model\iResource
   */
  public function read(\RestExample\Model\iResource $resource) {

  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Model\iResource
   */
  public function update(\RestExample\Model\iResource $resource) {

  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return boolean
   */
  public function delete(\RestExample\Model\iResource $resource) {
    
  }

}