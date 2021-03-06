<?php

namespace RestExample\Model\Resource;

class User implements \RestExample\Model\Resource\iUser {

  /**
   * @var int
   */
  private $identifier;

  /**
   * @var string
   */
  private $firstname;

  /**
   * @var string
   */
  private $surname;

  /**
   * @var boolean
   */
  private $isEmptyObject;

  /**
   * @param int $identifier
   */
  public function __construct($identifier = null) {
    $this->setIdentifer($identifier);
  }

  /**
   * @return int
   */
  public function getIdentifier() {
    return $this->identifier;
  }

  /**
   * @return boolean
   */
  public function isEmptyObject() {
    return $this->isEmptyObject;
  }

  /**
   * @return string
   */
  public function getFirstname() {
    return $this->firstname;
  }

  /**
   * @return string
   */
  public function getSurname() {
    return $this->surname;
  }

  /**
   * @param int $identifier
   * @throws \RestExample\Model\Exception\Immutable
   */
  public function setIdentifer($identifier) {
    if (\is_null($identifier)) {
      return;
    }

    if (isset($this->identifier)) {
      throw new \RestExample\Model\Exception\Immutable('Is not possible change resource identifier');
    }

    $this->identifier = (int) $identifier;
  }

  /**
   * @param boolean $isEmptyObject
   */
  public function setEmptyObject($isEmptyObject) {
    $this->isEmptyObject = $isEmptyObject;
  }

  /**
   * @param string $firstname
   */
  public function setFirstname($firstname) {
    $this->firstname = empty($firstname) ? null : (string) $firstname;
  }

  /**
   * @param string $surname
   */
  public function setSurname($surname) {
    $this->surname = empty($surname) ? null : (string) $surname;
  }

  /**
   * @return mixed[]
   */
  public function getData() {
    return [
      'firstname' => $this->getFirstname(),
      'surname' => $this->getSurname(),
    ];
  }

}