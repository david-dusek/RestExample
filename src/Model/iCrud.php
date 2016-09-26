<?php

namespace RestExample\Model;

interface iCrud {

  /**
   * @param \RestExample\Model\iResource $resource
   */
  public function create(\RestExample\Model\iResource $resource);

  /**
   * @param \RestExample\Model\iResource $resource
   */
  public function read(\RestExample\Model\iResource $resource);

  /**
   * @param \RestExample\Model\iResource $resource
   */
  public function update(\RestExample\Model\iResource $resource);

  /**
   * @param \RestExample\Model\iResource $resource
   */
  public function delete(\RestExample\Model\iResource $resource);
}