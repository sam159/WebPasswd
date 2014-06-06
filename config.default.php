<?php

return array(
  'Path' => '/',
  'Session' => array(
    'Timeout' => 3600,
    'Path' => '/',
    'Domain' => $_SERVER['HTTP_HOST']
  ),
  'SSLOnly' => true,
  'Auth' => array(
      'Username' => '#####', //Pick a username to login with
      'SessionName' => 'auth'
  ),
  'PasswdFile' => '#####', //Somewhere not accessible from the internet, ie your home dir /home/mysite/passwords
  'Debug' => false
);