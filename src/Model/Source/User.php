<?php

namespace RestExample\Model\Source;

class User implements \RestExample\Model\Source\iUser {

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
      throw new \RestExample\Model\Exception\Immutable('Is not possible change source identifier');
    }

    $this->identifier = (int) $identifier;
  }

  /**
   * @param string $firstname
   */
  public function setFirstname($firstname) {
    $this->firstname = (string) $firstname;
  }

  /**
   * @param string $surname
   */
  public function setSurname($surname) {
    $this->surname = (string) $surname;
  }

}