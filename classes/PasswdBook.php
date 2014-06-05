<?php

class PasswdBook implements ArrayAccess, IteratorAggregate, SplObserver {
  public static function CreateFromString($data) {
    $result = json_decode($data, true);
    if (!is_array($result)) {
      return false;
    }
    $entries = array();
    foreach($result as $entry) {
      $entries[] = new Passwd($entry['domain'], $entry['password'], $entry['username'], $entry['notes']);
    }
    return new PasswdBook($entries);
  }

  private $entries = array();
  private $changed = false;

  function __construct(array $entries) {
    $this->entries = $entries;
    foreach($this->entries as $passwd /* @var $passwd Passwd */) {
      $passwd->attach($this);
    }
    $this->sortEntries();
  }

  function sortEntries() {
    usort($this->entries, function($a, $b) {
      return strcmp($a->getDomain(), $b->getDomain());
    });
  }

  function hasChanged() {
    return $this->changed;
  }
  function markChanged() {
    $this->changed = true;
  }

  function add(Passwd $passwd) {
    $this->entries[] = $passwd;
    $passwd->attach($this);
    $this->changed = true;
    $this->sortEntries();
  }
  function remove($domain) {
    $self = $this;
    $this->entries = array_filter($this->entries, function($passwd) use ($domain, $self) {
      $match = strcmp($passwd->getDomain(),$domain) === 0;
      if ($match) {
        $passwd->detach($self);
      }
      return $match == false;
    });
    $this->changed = true;
  }

  /**
   * @param $domain
   *
   * @return bool|Passwd
   */
  function get($domain) {
    $result = array_filter($this->entries, function($passwd) use ($domain) {
      return strcmp($passwd->getDomain(),$domain) === 0;
    });
    if (count($result) == 0) {
      return false;
    }
    return current($result);
  }
  function hasDomain($domain) {
    return array_filter($this->entries, function($passwd) use ($domain) {
      return strcmp($passwd->getDomain(),$domain) === 0;
    }) !== array();
  }

  function toArray() {
    $entries = array();
    foreach($this->entries as $passwd) {
      $entries[] = $passwd->toArray();
    }
    return $entries;
  }

  function __toString() {
    return json_encode($this->toArray());
  }

  public function getIterator() {
    return new ArrayIterator($this->entries);
  }

  public function offsetExists($offset) {
    return $this->hasDomain($offset);
  }

  public function offsetGet($offset) {
    return $this->get($offset);
  }

  public function offsetSet($offset, $value) {
    return new RuntimeException("Not Implemented");
  }

  public function offsetUnset($offset) {
    $this->remove($offset);
  }

  public function update(SplSubject $subject) {
    $this->markChanged();
    $this->sortEntries();
  }
}