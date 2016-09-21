<?php

namespace RestExample\Model;

interface iMapper {

  /**
   * @param int|null $identifier
   * @param string $data
   * @return \RestExample\Model\iSource
   */
  public function dataToSource($identifier = null, $data = '');

  /**
   * @param \RestExample\Model\iSource $source
   * @return string
   */
  public function sourceToData(\RestExample\Model\iSource $source);
}