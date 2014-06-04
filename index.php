<?php

define('BASE_DIR',      dirname(__FILE__));
define('DS',            DIRECTORY_SEPARATOR);
define('DIR_TEMPLATES', BASE_DIR.DS.'templates');
define('DIR_TEMPLATES_COMPILED', DIR_TEMPLATES.DS.'compiled');
define('DIR_CLASSES',   BASE_DIR.DS.'classes');
chdir(BASE_DIR);

require 'functions.php';

$config = require 'config.php';

if ($config['SSLOnly'] && @$_SERVER['HTTPS'] != 'on') {
  redirect('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}

//Start the session
session_set_cookie_params(
    $config['Session']['Timeout'],
    $config['Session']['Path'],
    $config['Session']['Domain'],
    $config['SSLOnly'] ? true : false,
    true);
ini_set('session.gc_maxlifetime', $config['Session']['Timeout']);
session_name('WebPasswd_SID');
session_start() or die('Failed to start session');

remove_flashdata();

header('Cache-Control: no-store, no-cache. must-revalidate, pre-check=0');
header('Pragma: private');
header('Expires: '.gmdate('D, d M Y H:i:s T', strtotime('-10 years')));

//Insert autoloader
spl_autoload_register(function($class) {
  $class = str_replace('_', DS, $class);
  $file = DIR_CLASSES.DS.$class.'.php';

  if (file_exists($file)) {
    include $file;
  }
});

//Check MCrypt support

if (!function_exists('mcrypt_generic')) {
  die("MCrypt support required");
}
if (array_search(Crypt::CYPHER, mcrypt_list_algorithms()) === false ) {
  die('MCrypt does not support required cypher '.Crypt::CYPHER);
}

//Start Auth
$auth = new Auth($config);
/*register_shutdown_function(function() use($auth) {
  $auth->saveState();
});*/

//Determine action
$action = 'Default';
if (isset($_GET['action'])) {
  $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
  $action = preg_replace("/[^a-z0-9_\-]/i", "", $action);
}

//Run action
ob_start('ob_gzhandler');

$actionClass = 'Action_'.$action;
try {
  if (class_exists($actionClass) && is_subclass_of($actionClass, 'Action')) {

      $actionObj = new $actionClass($auth);
      echo $actionObj();
      unset($actionObj);

  } else {
    throw new NotFoundException("Unknown/Invalid Action");
  }
} catch (NotFoundException $ex) {
  while(ob_get_level() > 0) {ob_end_clean();}
  http_response_code(404);

  echo Template::GetInstance()->Render('error/404', array('ex'=>$ex,'message' => $ex->getMessage()));

} catch (NotAuthorisedException $ex) {

  if ($auth->isLoggedIn() == false) {
    redirect(action_url('Login'));
  }
  while(ob_get_level() > 0) {ob_end_clean();}

  http_response_code(403);
  echo Template::GetInstance()->Render('error/403', array('ex'=>$ex,'message' => $ex->getMessage()));

} catch (Exception $ex) {
  while(ob_get_level() > 0) {ob_end_clean();}

  http_response_code(500);
  echo Template::GetInstance()->Render('error/500', array('ex'=>$ex,'message' => $ex->getMessage()));

}
if (ob_get_level() > 0) {
  ob_end_flush();
}