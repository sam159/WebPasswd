<?php

class Action_View extends Action {

  function __invoke() {

    if (is_post()) {
      return $this->save();
    }

    $domain = filter_input(INPUT_GET, 'domain', FILTER_SANITIZE_STRING);

    $passwd = $this->auth->getPasswdBook()->get($domain);
    $title = $domain;
    if ($passwd == false) {
      $passwd = new Passwd($domain,'','','');
    }

    $saved = isset($_SESSION['saved']) && $_SESSION['saved'] == true;

    return Template::GetInstance()->Render('view', array(
      'title' => $title,
      'passwd' => $passwd,
      'saved' => $saved
    ));
  }

  function save() {
    $domain = filter_input(INPUT_GET, 'domain', FILTER_SANITIZE_STRING);

    $passwd = $this->auth->getPasswdBook()->get($domain);

    if ($passwd == false) {
      $passwd = new Passwd($domain, '', '', '');
      $this->auth->getPasswdBook()->add($passwd);
    }

    $passwd->setDomain(filter_input(INPUT_POST, 'domain', FILTER_SANITIZE_STRING));
    $passwd->setUsername(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $passwd->setPassword(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
    $passwd->setNotes(filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING));

    $this->auth->saveState();

    set_flashdata('saved', true);

    redirect(action_url('View').'&domain='.urlencode($passwd->getDomain()));
  }
}