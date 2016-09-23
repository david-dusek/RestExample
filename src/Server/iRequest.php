<?php

namespace RestExample\Server;

interface iRequest {

  /**
   * Method GET
   */
  const METHOD_GET = 'GET';

  /**
   * Method POST
   */
  const METHOD_POST = 'POST';

  /**
   * Method PUT
   */
  const METHOD_PUT = 'PUT';

  /**
   * Method DELETE
   */
  const METHOD_DELETE = 'DELETE';

  /**
   * @return string|null
   */
  public function getResourceName();

  /**
   * @return int|null
   */
  public function getResourceIdentifier();

  /**
   * @return string
   */
  public function getMethod();

  /**
   * @return string
   */
  public function getRawData();
}