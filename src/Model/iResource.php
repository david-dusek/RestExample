<?php

namespace RestExample\Model;

interface iResource {

  /**
   * @todo Other identifier type and compound key support.
   *
   * @return int|null
   */
  public function getIdentifier();
}