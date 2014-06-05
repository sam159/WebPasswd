<?php

class Action_Settings extends Action {

  function __invoke() {

    if (is_post() && filter_input(INPUT_GET, 'form') == 'password') {
      return $this->updatePassword();
    }

    $passwordMessage = '';
    if (isset($_SESSION['passwordMessage'])) {
      $passwordMessage = $_SESSION['passwordMessage'];
    }

    return Template::GetInstance()->Render('settings', array(
      'title' => 'Settings',
      'passwordMessage' => $passwordMessage
    ));
  }

  function updatePassword() {

    $current = filter_input(INPUT_POST,'current', FILTER_SANITIZE_STRING);
    $new = filter_input(INPUT_POST, 'new', FILTER_SANITIZE_STRING);
    $confirm = filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_STRING);

    if (empty($current) || empty($new) || empty($confirm)) {
      set_flashdata('passwordMessage', array('style'=>'alert','text'=>'Please enter all fields'));
      redirect(action_url('Settings'));
    }

    if (strcmp($new, $confirm) !== 0) {
      set_flashdata('passwordMessage', array('style'=>'alert','text'=>'Please check that your new passwords match'));
      redirect(action_url('Settings'));
    }

    if ($this->auth->updatePassword($current, $new)) {
      set_flashdata('passwordMessage', array('style'=>'success','text'=>'The password has been changed'));
      redirect(action_url('Settings'));
    } else {
      set_flashdata('passwordMessage', array('style'=>'alert','text'=>'Could not change the password, please try again'));
      redirect(action_url('Settings'));
    }

  }
}