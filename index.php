<?php

require 'include.php';

if (!is_file($config['PasswdFile'])) {
  redirect(base_href().'install.php');
}

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
} catch (NotFoundException $ex) { //404 Not Found Error
  while(ob_get_level() > 0) {ob_end_clean();}

  http_response_code(404);
  echo Template::GetInstance()->Render('error/404', array('ex'=>$ex,'message' => $ex->getMessage()));

} catch (NotAuthorisedException $ex) { //403 Not authorised -- redirect to login

  if ($auth->isLoggedIn() == false) {
    set_flashdata('redirect_to', $_SERVER['REQUEST_URI']);
    redirect(action_url('Login'));
  }
  while(ob_get_level() > 0) {ob_end_clean();}

  http_response_code(403);
  echo Template::GetInstance()->Render('error/403', array('ex'=>$ex,'message' => $ex->getMessage()));

} catch (Exception $ex) { //500 Internal Server Error - Someone went wrong :s
  while(ob_get_level() > 0) {ob_end_clean();}

  http_response_code(500);
  echo Template::GetInstance()->Render('error/500', array('ex'=>$ex,'message' => $ex->getMessage()));

}
if (ob_get_level() > 0) {
  ob_end_flush();
}