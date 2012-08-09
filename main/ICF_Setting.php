<?php

namespace framework\icf\main;

/**
 * @author Yoppy Yunhasnawa
 * @copyright 2011
 */

class ICF_Setting{
	
	// FIXME: Issue if the site have subdomain. E.g problem will presist if the url like www.yunhasnawa.com, but yunhasnawa.com will be okay
	const SITE_URL  = /*'180.248.41.175*/'localhost/spkmanager';
	
	const SITE_NAME = 'SPK Manager';
	
	const SITE_VERSION = '1.0';
	
	const DEBUG_ENV = true;
	
	const DSN = 'mysql:host=localhost;dbname=spkmanager';
	
	const DB_USERNAME = 'root';
	
	const DB_PASSWORD = '';
	
	const DB_DIE_ON_ERROR = true;
	
	const SITE_MODEL_DIRECTORY = 'model';
	
	const SITE_CONTROLLER_DIRECTORY = 'controller';
	
	const SITE_VIEW_DIRECTORY = 'view';
	
	const SITE_CSS_DIRECTORY = 'css';
	
	const SITE_JAVASCRIPT_DIRECTORY = 'ecma';
	
	const FRAMEWORK_DIRECTORY = 'framework';
	
	const AUTH_REDIRECT_PAGE = '/auth';
	
	const AUTH_CREDENTIAL_FILE = '/assets/credentials.auth';
	
	const SERVER_ENVIRONMENT_WINDOWS = 'windows';
	
	const SERVER_ENVIRONMENT_UNIX = 'unix';
	
	const SERVER_ENVIRONMET = ICF_Setting::SERVER_ENVIRONMENT_WINDOWS;
	
}


?>