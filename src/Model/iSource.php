<?php

namespace RestExample\Model;

interface iSource {

  /**
   * @todo Other identifier type and compound key support.
   *
   * @return int|null
   */
  public function getIdentifier();
}