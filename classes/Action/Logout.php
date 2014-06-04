<?php

class Action_Logout extends Action {

  function __invoke() {
    $this->auth->logout();
    redirect(action_url());
  }
}