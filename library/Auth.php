<?php

namespace framework\icf\library;

use framework\icf\main\ICF_Globals;

use framework\icf\main\ICF_Setting;
use framework\icf\main\ICF_Exception;

class Auth {
	
	const AUTH_TYPE_DB                    = 0;
	const AUTH_TYPE_FILE                  = 1;
	const SESSION_PASSWORD_KEY            = 'pswd';
	const SESSION_USERNAME_KEY            = 'user';
	const SESSION_ORIGIN_URI_KEY          = 'ouri';
	const AUTH_RESULT_NOT_LOGGED_IN       = 0;
	const AUTH_RESULT_WRONG_USERNAME      = 1;
	const AUTH_RESULT_WRONG_PASSWORD      = 2;
	const AUTH_RESULT_SUCCESS             = 3;
	const DEFAULT_SESSION_COOKIE_LIFESPAN = 3600;
	
	private $_username;
	private $_password;
	private $_redirectBack;
	
	public $authSourceType;
	public $authRedirectPage;
	public $authOriginUri;
	
	private function __construct($authSourceType = Auth::AUTH_TYPE_FILE)
	{
		$this->_username     = "";
		$this->_password     = "";
		$this->_redirectBack = true;
		
		$this->authSourceType   = $authSourceType;
		$this->authRedirectPage = Base::site_url(ICF_Setting::AUTH_REDIRECT_PAGE);
		
		$this->_beginSession();
		
		$this->authOriginUri = $this->_retrieveOriginUri();
	}
	
	public static function factory($authSourceType = Auth::AUTH_TYPE_FILE)
	{
		if(empty(ICF_Globals::$AUTH)) {
		
			$instance = new Auth();
		
		} else {
				
			$instance = ICF_Globals::$AUTH;
				
		}
		
		return $instance;
	}
	
	private function _beginSession()
	{
		session_set_cookie_params(Auth::DEFAULT_SESSION_COOKIE_LIFESPAN);
		session_start();
	}
	
	/**
	 * @return the $_username
	 */
	public function getUsername() {
		return $this->_username;
	}

	public function deautenthicate()
	{
		session_destroy();
		
		Base::redirect($this->authRedirectPage);
	}
	
	public function authenticate(/*$origin = "", */$username = "", $password = "")
	{
		//$this->authOriginUri = $origin;
		
		if(!empty($username))
			$_SESSION[Auth::SESSION_USERNAME_KEY] = $username;
		
		if(!empty($password))
			$_SESSION[Auth::SESSION_PASSWORD_KEY] = $password;
		
		if(empty($username) && empty($password)) {
			
			$originUri = ICF_Globals::$BROWSER_URL;
			
			$this->_saveOriginUri($originUri);
			
			$this->_redirectBack = false;
		}
		
		if($this->authSourceType == Auth::AUTH_TYPE_FILE) {
			$this->_authenticateFromFile();
		} elseif($this->authSourceType == Auth::AUTH_TYPE_DB) {
			$this->_authenticateFromDb();
		} else {
			throw new ICF_Exception(ICF_Exception::INVALID_AUTENTHICATION_TYPE);
		}
	}
	
	private function _authenticateFromDb()
	{
		throw new ICF_Exception(ICF_Exception::GENERAL_ERROR, "Not implemented yet..");
	}
	
	private function _authenticateFromFile()
	{
		$fileSource = Base::site_dir(ICF_Setting::AUTH_CREDENTIAL_FILE);
		
		$data = file_get_contents($fileSource);
		
		$credentials = explode(PHP_EOL, $data);

		$sessUsername = isset($_SESSION[Auth::SESSION_USERNAME_KEY]) ? 
			$_SESSION[Auth::SESSION_USERNAME_KEY] : false;
		$sessPassword = isset($_SESSION[Auth::SESSION_PASSWORD_KEY]) ?
			$_SESSION[Auth::SESSION_PASSWORD_KEY]: false;
		
		if($sessPassword !== false && $sessUsername !== false) {
		
			$result = Auth::AUTH_RESULT_WRONG_USERNAME;

			foreach ($credentials as $user) {
				
				$expl = explode('|', $user);
				
				$username = $expl[0];
				$group    = $expl[1];
				$password = $expl[2];
				
				if($sessUsername === $username) {
					if($sessPassword === $password) {
						$result = Auth::AUTH_RESULT_SUCCESS;
						$this->_username = $username;
						$this->_password = $password;
						break;
					} else {
						$result = Auth::AUTH_RESULT_WRONG_PASSWORD;
					}
				}
			}
		
		} else {
			
			$result = Auth::AUTH_RESULT_NOT_LOGGED_IN;
			
		}
		
		$this->_processAuthResult($result);
		
	}
	
	private function _processAuthResult($result)
	{
		switch ($result) {
			case Auth::AUTH_RESULT_NOT_LOGGED_IN :
				$message = 'Not logged in!';
				break;
			case Auth::AUTH_RESULT_WRONG_USERNAME :
				$message = 'Wrong username!';
				break;
			case Auth::AUTH_RESULT_WRONG_PASSWORD :
				$message = 'Wrong password!';
				break;
			case Auth::AUTH_RESULT_SUCCESS :
				$message = '';
		}
		
		if(!empty($message)) {
			
			$decodedMessage = urlencode(base64_encode($message));
			$url = $this->authRedirectPage . "?message=$decodedMessage";

			Base::redirect($url);
		} else {
			if(!empty($this->authOriginUri) && $this->_redirectBack) {
				$this->_redirectToOriginPage();
			}
		}
	}
	
	private function _redirectToOriginPage()
	{
		unset($_SESSION[Auth::SESSION_ORIGIN_URI_KEY]);
		Base::redirect($this->authOriginUri);
	}
	
	private function _saveOriginUri($originUri)
	{
		$_SESSION[Auth::SESSION_ORIGIN_URI_KEY] = $originUri;
	}
	
	private function _retrieveOriginUri()
	{	
		return isset($_SESSION[Auth::SESSION_ORIGIN_URI_KEY]) && !empty($_SESSION[Auth::SESSION_ORIGIN_URI_KEY]) ? 
			$_SESSION[Auth::SESSION_ORIGIN_URI_KEY] : '';
	}
	
	public function decodeMessage($authString)
	{
		$message = base64_decode(urldecode($authString));
		
		return $message;
	}
	
}

?>