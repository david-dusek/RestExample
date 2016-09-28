<?php

namespace RestExample\Server\Response;

class Http implements \RestExample\Server\iResponse {

  /**
   * @var string[]
   */
  private $headers = [];

  /**
   * @var int \RestExample\Server\iResponse::CODE_*
   */
  private $statusCode;

  /**
   * @var string
   */
  private $content = '';

  public function send() {
    $this->sendHeaders();
    $this->sendContent();
  }

  /**
   * @param int $statusCode \RestExample\Server\iResponse::CODE_*
   */
  public function setStatusCode($statusCode) {
    $this->statusCode = $statusCode;
  }

  /**
   * @param string $contentType \RestExample\Server\iResponse::CONTENT_TYPE_*
   */
  public function setContentType($contentType) {
    $this->headers['Content-Type'] = $contentType;
  }

  /**
   * @param string $content
   */
  public function setContent($content) {
    $this->content = $content;
  }

  private function sendHeaders() {
    foreach ($this->headers as $name => $value) {
      \header("$name: $value", false, $this->statusCode);
    }
  }

  private function sendContent() {
    echo $this->content;
  }

}