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
    try {
      $resource = $this->dataMapper->dataToResource($request->getResourceIdentifier(), $request->getRawData());

      $methodName = 'process' . \ucfirst(\strtolower($request->getMethod()));
      if (!\method_exists($this, $methodName)) {
        return $this->createResponse(\RestExample\Server\iResponse::CODE_METHOD_NOT_ALLOWED);
      }

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
    if (\is_null($resource->getIdentifier())) {
      $this->createResponse(\RestExample\Server\iResponse::CODE_NOT_FOUND);
    }
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
    if (\is_null($resource->getIdentifier())) {
      $this->createResponse(\RestExample\Server\iResponse::CODE_NOT_FOUND);
    }
    $this->resourceManager->update($resource);

    return $this->createResponseFromResource(\RestExample\Server\iResponse::CODE_OK, $resource);
  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return \RestExample\Server\iResponse
   */
  private function processDelete(\RestExample\Model\iResource $resource) {
    if (\is_null($resource->getIdentifier())) {
      $this->createResponse(\RestExample\Server\iResponse::CODE_NOT_FOUND);
    }
    $this->resourceManager->delete($resource);

    return $this->createResponseFromResource(\RestExample\Server\iResponse::CODE_OK, $resource);
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
      $content = null;
    } else {
      $content = $this->dataMapper->resourceToData($resource);
    }

    return $this->createResponse($code, $content);
  }

  /**
   * @param int $code
   * @param string $content JSON
   * @return \RestExample\Server\iResponse
   */
  private function createResponse($code, $content = null) {
    $response = $this->responseFactory->createResponse();
    $response->setStatusCode($code);
    $response->setContentType(\RestExample\Server\iResponse::CONTENT_TYPE_JSON);
    $response->setContent($content);

    return $response;
  }

}