<?php

namespace RestExample;

class Controller implements \RestExample\iController {

  /**
   * @var \RestExample\Model\iCrud
   */
  private $resourceManager;

  /**
   * @var \RestExample\Model\iMapper
   */
  private $dataMapper;

  /**
   * @param \RestExample\Model\iCrud $resourceManager
   * @param \RestExample\Model\iMapper $dataMapper
   */
  public function __construct(\RestExample\Model\iCrud $resourceManager, \RestExample\Model\iMapper $dataMapper) {
    $this->resourceManager = $resourceManager;
    $this->dataMapper = $dataMapper;
  }

  /**
   * @param \RestExample\Server\iRequest $request
   */
  public function processRequest(\RestExample\Server\iRequest $request) {
    $request->getMethod();
    $resource = $this->dataMapper->dataToResource($request->getResourceIdentifier(), $request->getRawData());

    $methodName = 'process' . \ucfirst(\strtolower($request->getMethod()));
    if (!\method_exists($this, $methodName)) {
      throw new \RestExample\Controller\Exception\UnsupportedMethod("Method {$request->getMethod()} is not supported.");
    }
    $this->{$methodName}($resource);
  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Model\iResource
   */
  protected function processGet(\RestExample\Model\iResource $resource) {
    return $this->resourceManager->read($resource);
  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Model\iResource
   */
  protected function processPost(\RestExample\Model\iResource $resource) {
    return $this->resourceManager->create($resource);
  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Model\iResource
   */
  protected function processPut(\RestExample\Model\iResource $resource) {
    return $this->resourceManager->update($resource);
  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return boolean
   */
  protected function processDelete(\RestExample\Model\iResource $resource) {
    return $this->resourceManager->delete($resource);
  }

}