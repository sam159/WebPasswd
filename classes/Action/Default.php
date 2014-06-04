<?php

class Action_Default extends Action {

  function __invoke() {

    return $this->template->Render('home', array(
      'title'=> 'Domain Listing',
      'book' => $this->auth->getPasswdBook()
    ));

  }
}