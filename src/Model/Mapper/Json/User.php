<?php

namespace RestExample\Model\Mapper\Json;

class User implements \RestExample\Model\iMapper {

  /**
   * @param int|null $identifier
   * @param string $data
   * @return \RestExample\Model\iResource
   */
  public function dataToResource($identifier = null, $data = '') {
    $encodedData = \json_decode($data);
    if (!empty($data) && !($encodedData instanceof \stdClass)) {
      throw new \RestExample\Model\Exception\InvalidJson("Unable to decode JSON '$data'");
    }
    $user = new \RestExample\Model\Resource\User($identifier);
    $user->setFirstname(isset($encodedData->firstname) ? $encodedData->firstname : null);
    $user->setSurname(isset($encodedData->surname) ? $encodedData->surname : null);

    return $user;
  }

  /**
   * @param \RestExample\Model\iResource $resource
   * @return string
   */
  public function resourceToData(\RestExample\Model\iResource $resource) {
    $values = [
      'identifier' => $resource->getIdentifier(),
      'firstname' => $resource->getFirstname(),
      'surname' => $resource->getSurname(),
    ];

    return json_encode((object) array_filter($values));
  }

}