<?php

return array(
  'Path' => '/',
  'Session' => array(
    'Timeout' => 3600,
    'Path' => '/',
    'Domain' => $_SERVER['HTTP_HOST']
  ),
  'SSLOnly' => false,
  'Auth' => array(
      'Username' => 'sam',
      'SessionName' => 'auth'
  ),
  'PasswdFile' => 'test.txt'
);