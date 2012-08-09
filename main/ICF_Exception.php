<?php

namespace framework\icf\main;

use \Exception;

class ICF_Exception extends Exception {
	
	const GENERAL_ERROR               = 170000;
	const INVALID_MODEL_DIRECTORY     = 170101;
	const INVALID_MODEL_FILE_NAME     = 170102;
	const INVALID_MODEL_CLASS_NAME    = 170103;
	const INVALID_AUTENTHICATION_TYPE = 170201;
	
	const GENERAL_ERROR_MESSAGE               = 'Unhandled exception occured';
	const INVALID_MODEL_DIRECTORY_MESSAGE     = 'The Model class file is not properly placed, use model directory defined in framework/Setting.php';
	const INVALID_MODEL_FILE_NAME_MESSAGE     = "The Model file name doesn't not contain 'Model_' prefix";
	const INVALID_MODEL_CLASS_NAME_MESSAGE    = "The Model class name doesn't contain 'Model_' prefix";
	const INVALID_AUTENTHICATION_TYPE_MESSAGE = 'Invalid authentication type! Use either Auth::AUTH_TYPE_DB or Auth::AUTH_TYPE_FILE';
	
	public function __construct($code = ICF_Exception::GENERAL_ERROR, $message = '') {
		
		$excMessage = empty($message) ? $this->_findExceptionMessageFromCode($code) : $message;
		
		parent::__construct($excMessage, $code);
		
	}
	
	private function _findExceptionMessageFromCode($code) {
		
		switch ($code) {
			case ICF_Exception::INVALID_MODEL_DIRECTORY : 
				$message = ICF_Exception::INVALID_MODEL_DIRECTORY_MESSAGE;
				break;
			case ICF_Exception::INVALID_MODEL_FILE_NAME :
				$message = ICF_Exception::INVALID_MODEL_FILE_NAME_MESSAGE;
				break;
			case ICF_Exception::INVALID_MODEL_CLASS_NAME :
				$message = ICF_Exception::INVALID_MODEL_CLASS_NAME_MESSAGE;
				break;
			default:
				$message = ICF_Exception::GENERAL_ERROR_MESSAGE;
		}
		
		return $message;
		
	}
	
}

?>