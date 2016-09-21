<?php

namespace RestExample;

class Controller implements \RestExample\iController {

  /**
   * @var \RestExample\Model\iCrud
   */
  private $sourceManager;

  /**
   * @var \RestExample\Model\iMapper
   */
  private $dataMapper;

  /**
   * @param \RestExample\Model\iCrud $sourceManager
   * @param \RestExample\Model\iMapper $dataMapper
   */
  public function __construct(\RestExample\Model\iCrud $sourceManager, \RestExample\Model\iMapper $dataMapper) {
    $this->sourceManager = $sourceManager;
    $this->dataMapper = $dataMapper;
  }

  /**
   * @param \RestExample\Server\iRequest $request
   */
  public function processRequest(\RestExample\Server\iRequest $request) {
    $request->getMethod();
    $source = $this->dataMapper->dataToSource($request->getSourceIdentifier(), $request->getRawData());

    $methodName = 'process' . \ucfirst(\strtolower($request->getMethod()));
    if (!\method_exists($this, $methodName)) {
      throw new \RestExample\Controller\Exception\UnsupportedMethod("Method {$request->getMethod()} is not supported.");
    }
    $this->{$methodName}($source);
  }

  /**
   * @param \RestExample\Model\iSource $source
   * @return \RestExample\Model\iSource
   */
  protected function processGet(\RestExample\Model\iSource $source) {
    return $this->sourceManager->read($source);
  }

  /**
   * @param \RestExample\Model\iSource $source
   * @return \RestExample\Model\iSource
   */
  protected function processPost(\RestExample\Model\iSource $source) {
    return $this->sourceManager->create($source);
  }

  /**
   * @param \RestExample\Model\iSource $source
   * @return \RestExample\Model\iSource
   */
  protected function processPut(\RestExample\Model\iSource $source) {
    return $this->sourceManager->update($source);
  }

  /**
   * @param \RestExample\Model\iSource $source
   * @return boolean
   */
  protected function processDelete(\RestExample\Model\iSource $source) {
    return $this->sourceManager->delete($source);
  }

}