<?php

namespace RestExample;

interface iController {

  /**
   * @param \RestExample\Server\iRequest $request
   * @return \RestExample\Server\iResponse
   */
  public function processRequest(\RestExample\Server\iRequest $request);
}