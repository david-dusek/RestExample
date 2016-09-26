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
   * @var \RestExample\Server\Response\Factory
   */
  private $responseFactory;

  /**
   * @param \RestExample\Model\iCrud $resourceManager
   * @param \RestExample\Model\iMapper $dataMapper
   */
  public function __construct(\RestExample\Model\iCrud $resourceManager, \RestExample\Model\iMapper $dataMapper,
                              \RestExample\Server\Response\Factory $responseFactory) {
    $this->resourceManager = $resourceManager;
    $this->dataMapper = $dataMapper;
    $this->responseFactory = $responseFactory;
  }

  /**
   * @param \RestExample\Server\iRequest $request
   * @return \RestExample\Server\iResponse
   */
  public function processRequest(\RestExample\Server\iRequest $request) {
    $request->getMethod();
    $resource = $this->dataMapper->dataToResource($request->getResourceIdentifier(), $request->getRawData());

    $methodName = 'process' . \ucfirst(\strtolower($request->getMethod()));
    if (!\method_exists($this, $methodName)) {
      throw new \RestExample\Controller\Exception\UnsupportedMethod("Method {$request->getMethod()} is not supported.");
    }

    try {
      return $this->{$methodName}($resource);
    } catch (\RestExample\Exception $restExampleException) {
      return $this->createResponse(\RestExample\Server\iResponse::CODE_SERVER_ERROR,
                      $this->prepareErrorData($restExampleException->getMessage()));
    } catch (\Exception $exception) {
      return $this->createResponse(\RestExample\Server\iResponse::CODE_SERVER_ERROR,
                      $this->prepareErrorData('Unexpected Error'));
    }
  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Server\iResponse
   */
  private function processGet(\RestExample\Model\iResource $resource) {
    $this->resourceManager->read($resource);
    if ($resource->isEmptyObject()) {
      return $this->createResponse(\RestExample\Server\iResponse::CODE_NOT_FOUND);
    }
    return $this->createResponseFromResource(\RestExample\Server\iResponse::CODE_OK, $resource);
  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Server\iResponse
   */
  private function processPost(\RestExample\Model\iResource $resource) {
    $this->resourceManager->create($resource);

    return $this->createResponseFromResource(\RestExample\Server\iResponse::CODE_CREATE_OK, $resource);
  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Server\iResponse
   */
  private function processPut(\RestExample\Model\iResource $resource) {
    $this->resourceManager->update($resource);

    return $this->createResponseFromResource(\RestExample\Server\iResponse::CODE_OK, $resource);
  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Server\iResponse
   */
  private function processDelete(\RestExample\Model\iResource $resource) {
    $this->resourceManager->delete($resource);

    return $this->createResponseFromResource(\RestExample\Server\iResponse::CODE_DELETE_OK, $resource);
  }

  /**
   * @param string $message
   * @return string JSON
   */
  private function prepareErrorData($message) {
    $error = new \stdClass();
    $error->error = $message;

    return \json_encode($error);
  }

  /**
   * @param int $code
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Server\iResponse
   */
  private function createResponseFromResource($code, \RestExample\Model\iResource $resource = null) {
    if (\is_null($resource)) {
      $data = null;
    } else {
      $data = $this->dataMapper->resourceToData($resource);
    }

    return $this->createResponse($code, $data);
  }

  /**
   * @param int $code
   * @param string $data JSON
   * @return \RestExample\Server\iResponse
   */
  private function createResponse($code, $data = null) {
    $response = $this->responseFactory->createResponse();
    $response->setCode($code);
    $response->setContentType(\RestExample\Server\iResponse::CONTENT_TYPE_JSON);
    $response->setData($data);

    return $response;
  }

}