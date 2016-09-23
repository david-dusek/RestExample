<?php

namespace RestExample\Model\Resource;

interface iUser extends \RestExample\Model\iResource {

  /**
   * @return string
   */
  public function getFirstname();

  /**
   * @return string
   */
  public function getSurname();

  /**
   * @param int $identifier
   * @throws \RestExample\Model\Exception\Immutable
   */
  public function setIdentifer($identifier);

  /**
   * @param string $firstname
   */
  public function setFirstname($firstname);

  /**
   * @param string $surname
   */
  public function setSurname($surname);
}