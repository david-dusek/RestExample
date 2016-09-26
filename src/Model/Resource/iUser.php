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
   * @param string $firstname
   */
  public function setFirstname($firstname);

  /**
   * @param string $surname
   */
  public function setSurname($surname);
}