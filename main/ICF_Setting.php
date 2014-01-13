<?php

/**
 * @author Yoppy Yunhasnawa
 * @copyright 2011
 */

namespace icf\main;

require_once 'icf/main/ICF_Constants.php';

class ICF_Setting{
	
	private static $_instance;
	
	public $siteUrl;
	public $siteName;
	public $siteVersion;
	public $debugEnvironment;
	public $dsn;
	public $dbUsername;
	public $dbPassword;
	public $dbDieOnError;
	public $siteModuleDirectory;
	public $siteModelDirectory;
	public $siteControllerDirectory;
	public $siteViewDirectory;
	public $siteStyleDirectory;
	public $siteScriptDirectory;
	public $frameworkDirectory;
	public $authRedirectPage;
	public $authCredentialFile;
	public $serverEnvironment;
	
	private function __construct()
	{
		$this->siteUrl                 = 'localhost/jayuz';
		$this->siteName                = 'Jayuz';
		$this->siteVersion             = '1.0';
		$this->debugEnvironment        = true;
		$this->dsn                     = 'mysql:host=localhost;dbname=jayuz';
		$this->dbUsername              = 'root';
		$this->dbPassword              = 'bismillah';
		$this->dbDieOnError            = true;
		$this->siteModuleDirectory     = 'modules';
		$this->siteModelDirectory      = 'model';
		$this->siteControllerDirectory = 'controller';
		$this->siteViewDirectory       = 'view';
		$this->siteStyleDirectory      = 'css';
		$this->siteScriptDirectory     = 'ecma';
		$this->frameworkDirectory      = 'framework';
		$this->authRedirectPage        = '/auth';
		$this->authCredentialFile      = '/assets/credentials.auth';
		$this->serverEnvironment       = ICF_Constants::SERVER_ENVIRONMENT_UNIX;
	}
	
	public static function getInstance()
	{
		if(ICF_Setting::$_instance == null)
		{
			ICF_Setting::$_instance = new ICF_Setting();
		}
		
		return ICF_Setting::$_instance;
	}
	
	public function set(array $settings)
	{
		
	}
}

?>