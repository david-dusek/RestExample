<?php

namespace RestExample\Server;

interface iResponse {

  /**
   * Eyerything is working
   */
  const CODE_OK = 200;

  /**
   * New resource has been created
   */
  const CODE_CREATE_OK = 201;

  /**
   * The resource was successfully deleted
   */
  const CODE_DELETE_OK = 204;

  /**
   * Bad Request
   */
  const CODE_BAD_REQUEST = 400;

  /**
   * Not found
   */
  const CODE_NOT_FOUND = 404;

  /**
   * Internal Server Error
   */
  const CODE_SERVER_ERROR = 500;

  /**
   * JSON
   */
  const CONTENT_TYPE_JSON = 'application/json';

  public function send();

  /**
   * @param int $code \RestExample\Server\iResponse::CODE_*
   */
  public function setCode($code);

  /**
   * @param string $contentType \RestExample\Server\iResponse::CONTENT_TYPE_*
   */
  public function setContentType($contentType);

  /**
   * @param string $data
   */
  public function setData($data);
}