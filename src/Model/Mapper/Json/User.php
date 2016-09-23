<?php

namespace RestExample\Model\Mapper\Json;

class User implements \RestExample\Model\iMapper {

  /**
   * @param int|null $identifier
   * @param string $data
   * @return \RestExample\Model\iSource
   */
  public function dataToSource($identifier = null, $data = '') {
    $encodedData = \json_decode($data);
    if (!($encodedData instanceof \stdClass)) {
      throw new \RestExample\Model\Exception\InvalidJson("Unable to decode JSON '$data'");
    }

    \var_dump($encodedData);

    $user = new \RestExample\Model\Source\User($identifier);
    $user->setFirstname(isset($encodedData->firstname) ? $encodedData->firstname : null);
    $user->setSurname(isset($encodedData->surname) ? $encodedData->surname : null);

    return $user;
  }

  /**
   * @param \RestExample\Model\iSource $source
   * @return string
   */
  public function sourceToData(\RestExample\Model\iSource $source) {


    $values = [
      'identifier' => $source->getIdentifier(),
      'firstname' => $source->getFirstname(),
      'surname' => $source->getSurname(),
    ];

    return json_encode((object) array_filter($values));
  }

}