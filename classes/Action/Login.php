<?php

class Action_Login extends Action {

  function __invoke() {

    $username = "";
    $message = false;

    if (is_post()) {
      $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
      $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

      if ($this->auth->tryLogin($username, $password)) {
        redirect(action_url());
      } else {
        $message = 'Username or password were not correct';
      }
    }

    return $this->template->Render('login', array(
      'title' => 'Login',
      'username' => $username,
      'message' => $message
    ));

  }

  function requiresLogin() {
    return false;
  }


}