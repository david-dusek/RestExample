<?php

namespace RestExample\Server\Response;

class Factory {

  /**
   * @return \RestExample\Server\iResponse
   */
  public function createResponse() {
    return new \RestExample\Server\Response\Http();
  }

}