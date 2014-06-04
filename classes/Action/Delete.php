<?php

class Action_Delete extends Action {

  function __invoke() {

    $domain = filter_input(INPUT_GET, 'domain', FILTER_SANITIZE_STRING);

    $passwd = $this->auth->getPasswdBook()->get($domain);

    if ($passwd == false) {
      throw new NotFoundException("Could not find entry for domain $domain");
    }

    if (is_post()) {
      $this->auth->getPasswdBook()->remove($domain);
      $this->auth->saveState();

      redirect(action_url());
    }

    return Template::GetInstance()->Render('delete', array(
      'title' => 'Delete Entry',
      'passwd' => $passwd
    ));

  }
}