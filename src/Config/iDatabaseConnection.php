<?php

namespace RestExample\Config;

interface iDatabaseConnection {

  /**
   * @return string
   */
  public function getdatabaseConnectionDsn();

  /**
   * @return string
   */
  public function getdatabaseConnectionUsername();

  /**
   * @return string
   */
  public function getdatabaseConnectionPassword();
}