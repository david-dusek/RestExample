<?php

namespace RestExample\Model;

interface iCrud {

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Model\iResource
   */
  public function create(\RestExample\Model\iResource $resource);

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Model\iResource
   */
  public function read(\RestExample\Model\iResource $resource);

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Model\iResource
   */
  public function update(\RestExample\Model\iResource $resource);

  /**
   * @param \RestExample\Model\iResource $resource
   * @return boolean
   */
  public function delete(\RestExample\Model\iResource $resource);
}