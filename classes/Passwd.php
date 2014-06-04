<?php

class Passwd implements SplSubject {

  private $domain;
  private $username;
  private $password;
  private $notes;

  function __construct($domain, $password, $username, $notes) {
    $this->domain = $domain;
    $this->notes = $notes;
    $this->password = $password;
    $this->username = $username;
  }

  /**
   * @param string $domain
   */
  public function setDomain($domain) {
    $this->domain = $domain;
    $this->notify();
  }

  /**
   * @return string
   */
  public function getDomain() {
    return $this->domain;
  }

  /**
   * @param string $notes
   */
  public function setNotes($notes) {
    $this->notes = $notes;
    $this->notify();
  }

  /**
   * @return string
   */
  public function getNotes() {
    return $this->notes;
  }

  /**
   * @param string $password
   */
  public function setPassword($password) {
    $this->password = $password;
    $this->notify();
  }

  /**
   * @return string
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * @param string $username
   */
  public function setUsername($username) {
    $this->username = $username;
    $this->notify();
  }

  /**
   * @return string
   */
  public function getUsername() {
    return $this->username;
  }

  public function toArray() {
    return array(
      'domain' => $this->getDomain(),
      'username' => $this->getUsername(),
      'password' => $this->getPassword(),
      'notes' => $this->getNotes()
    );
  }

  private $observers = array();

  public function attach(SplObserver $observer) {
    $this->observers[] = $observer;
  }

  public function detach(SplObserver $observer) {
    $this->observers = array_filter($this->observers, function($val) use($observer) {
      return $val !== $observer;
    });
  }

  public function notify () {
    foreach($this->observers as $ob/* @var $ob SplObserver */) {
      $ob->update($this);
    }
  }
}