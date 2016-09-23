<?php

namespace RestExample\Model;

interface iMapper {

  /**
   * @param int|null $identifier
   * @param string $data
   * @return \RestExample\Model\iResource
   */
  public function dataToResource($identifier = null, $data = '');

  /**
   * @param \RestExample\Model\iResource $resource
   * @return string
   */
  public function resourceToData(\RestExample\Model\iResource $resource);
}