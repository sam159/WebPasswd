<?php

if (!file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php')) {
  die('Please create your config.php before proceeding with the install');
}

require 'include.php';

if (file_exists($config['PasswdFile'])) {
  echo Template::GetInstance()->Render('install/already_installed', array(
      'title' => 'Installation'
  ));
  exit();
}

if (is_post()) {
  $new = filter_input(INPUT_POST, 'new', FILTER_SANITIZE_STRING);
  $confirm = filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_STRING);

  if (empty($new) || empty($confirm)) {
    set_flashdata('message', array('style'=>'alert','text'=>'Please supply both password fields'));
    redirect(base_href().'install.php');
  }

  if (strcmp($new, $confirm) !== 0) {
    set_flashdata('message', array('style'=>'alert','text'=>'Please ensure both passwords match'));
    redirect(base_href().'install.php');
  }

  if (strlen($new) < 6) {
    set_flashdata('message', array('style'=>'alert','text'=>'Please choose a longer password'));
    redirect(base_href().'install.php');
  }

  $passwd = new PasswdBook(array());
  $crypt = new Crypt($config['PasswdFile'], $new);
  $result = $crypt->Encrypt((string)$passwd);
  if ($result == false) {
    if (is_file($config['PasswdFile'])) {
      unlink($config['PasswdFile']);
    }
    set_flashdata('message', array('style'=>'alert','text'=>'Sorry, there was an error creating the passwords file'));
    redirect(base_href().'install.php');
  }

  echo Template::GetInstance()->Render('install/finished', array(
      'title' => 'Installation Complete'
  ));
  exit();
}

$message = false;
if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
}

$writeError = false;
//Test writing to the file
if (touch($config['PasswdFile']) == false) {
  $writeError = true;
}
if (is_file($config['PasswdFile'])) {
  unlink($config['PasswdFile']);
}

echo Template::GetInstance()->Render('install/install', array(
  'title' => 'Installation',
  'username' => $config['Auth']['Username'],
  'message' => $message,
  'writeError' => $writeError
));