<?php

class NotFoundException extends Exception {

  function __construct($message) {
    $this->message = $message;
  }
}