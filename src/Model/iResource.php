<?php

namespace RestExample\Model;

interface iResource {

  /**
   * @param int $identifier
   */
  public function setIdentifer($identifier);

  /**
   * @todo Other identifier type and compound key support.
   *
   * @return int|null
   */
  public function getIdentifier();

  /**
   * @param boolean $isEmptyObject
   */
  public function setEmptyObject($isEmptyObject);

  /**
   * @return boolean
   */
  public function isEmptyObject();

  /**
   * @return mixed[]
   */
  public function getData();
}