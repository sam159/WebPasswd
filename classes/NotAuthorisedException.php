<?php

class NotAuthorisedException extends Exception {

  function __construct($message) {
    $this->message = $message;
  }

}