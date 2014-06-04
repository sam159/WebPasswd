<?php

abstract class Action {
  /**
   * @var Template
   */
  protected $template;

  /**
   * @var Auth
   */
  protected $auth;

  function __construct(Auth $auth) {
    $this->template = Template::GetInstance();
    $this->auth = $auth;
    if ($this->requiresLogin()) {
      $this->auth->requireLoggedIn();
    }
  }

  function requiresLogin() {
    return true;
  }


  abstract function __invoke();
}