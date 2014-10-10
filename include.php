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
$config['SSLOnly'] ? true : false, true);
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