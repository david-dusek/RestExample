<?php

namespace RestExample\Model;

interface iCrud {

  /**
   * @param \RestExample\Model\iSource $source
   * @return \RestExample\Model\iSource
   */
  public function create(\RestExample\Model\iSource $source);

  /**
   * @param \RestExample\Model\iSource $source
   * @return \RestExample\Model\iSource
   */
  public function read(\RestExample\Model\iSource $source);

  /**
   * @param \RestExample\Model\iSource $source
   * @return \RestExample\Model\iSource
   */
  public function update(\RestExample\Model\iSource $source);

  /**
   * @param \RestExample\Model\iSource $source
   * @return boolean
   */
  public function delete(\RestExample\Model\iSource $source);
}