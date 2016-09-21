<?php

namespace RestExample\Model\Source;

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
   * @param \RestExample\Model\iSource $source
   * @return \RestExample\Model\iSource
   */
  public function create(\RestExample\Model\iSource $source) {

  }

  /**
   * @param \RestExample\Model\iSource $source
   * @return \RestExample\Model\iSource
   */
  public function read(\RestExample\Model\iSource $source) {

  }

  /**
   * @param \RestExample\Model\iSource $source
   * @return \RestExample\Model\iSource
   */
  public function update(\RestExample\Model\iSource $source) {

  }

  /**
   * @param \RestExample\Model\iSource $source
   * @return boolean
   */
  public function delete(\RestExample\Model\iSource $source) {
    
  }

}