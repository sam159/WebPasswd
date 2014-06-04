<?php

if (!function_exists('http_response_code')) {
  function http_response_code($response_code) {
    header(':', true, $response_code);
  }
}

/**
 * Detects if the request method is post
 * @return boolean
 */
function is_post() {
  return $_SERVER['REQUEST_METHOD'] == "POST";
}

/**
 * Redirect the client to a new url
 *
 * @param string $url the url to redirect to
 */
function redirect($url) {
  //Can't redirect the console
  if (php_sapi_name() == 'cli')
    return;

  header("Location: $url");

  echo <<<EOT
<html>
  <head>
      <title>Redirecting</title>
      <meta http-equiv="refresh" content="0;URL='$url'" />
  </head>
  <body>
      Redirecting to <a href="$url">$url</a>
  </body>
</html>
EOT;

  exit;
}

/**
 * Stores a key the session for one page view
 *
 * @see remove_flashdata
 * @param string $name
 * @param mixed $data
 */
function set_flashdata($name, $data) {
  if (!isset($_SESSION['FLASHDATA']))
    $_SESSION['FLASHDATA'] = array($name => 1);
  else
    $_SESSION['FLASHDATA'][$name] = 1;

  $_SESSION[$name] = $data;
}

/**
 * Remove all flash data that has been through one page view already
 *
 * @return void
 */
function remove_flashdata() {
  if (isset($_SESSION['FLASHDATA'])) {
    foreach ($_SESSION['FLASHDATA'] as $name => $views) {
      if ($_SESSION['FLASHDATA'][$name] == 0) {
        unset($_SESSION[$name]);
        unset($_SESSION['FLASHDATA'][$name]);
      }
      else
        $_SESSION['FLASHDATA'][$name] -= 1;
    }
  }
}

function is_https() {
  return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
}

function action_url($action='Default', $append='') {
  global $config;

  return $config['Path'].'?action='.$action.($append!=''?'&':'').$append;
}

function base_href() {
  global $config;

  return (is_https()?'https':'http').'://'.$_SERVER['HTTP_HOST'].$config['Path'];
}