<?php

use framework\icf\library\Auth;

use framework\icf\pattern\View;

/**
 * @author Yoppy Yunhasnawa
 * @copyright 2011
 */

// Root of all ICF Objects
include_once 'main/ICF_Object.php';
// Data Context
include_once 'data_context/Connection_Account.php';
include_once 'data_context/Database_Access.php';
// Libraries
include_once 'library/Auth.php';
include_once 'library/Base.php';
include_once 'library/Sql.php';
// Main
include_once 'main/ICF_Application.php';
include_once 'main/ICF_Exception.php';
include_once 'main/ICF_Globals.php';
include_once 'main/ICF_Setting.php';
// Pattern
include_once 'pattern/IPattern.php';
include_once 'pattern/Controller.php';
include_once 'pattern/Model.php';
include_once 'pattern/View.php';

use framework\icf\library\Base;
use framework\icf\main\ICF_Setting;
use framework\icf\main\ICF_Globals;

if(ICF_Setting::DEBUG_ENV) {
	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', Base::site_dir('log/error/error_log.txt'));
	error_reporting(E_ALL);
}

$requestUri = $_SERVER['REQUEST_URI'] == '' ? '/index.php' : $_SERVER['REQUEST_URI'];

$url = $_SERVER['SERVER_NAME'] . $requestUri;

ICF_Globals::$BROWSER_URL = $url;

// TODO: Create root of all object -> ICF_Object

$slash = ICF_Setting::SERVER_ENVIRONMET == ICF_Setting::SERVER_ENVIRONMENT_UNIX ? '/' : '\\';

define('SLASH', $slash);

?>