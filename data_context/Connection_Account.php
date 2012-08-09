<?php

namespace framework\icf\data_context;

use framework\icf\main\ICF_Setting;

class Connection_Account {
	
	private $_dsn;
	
	private $_username;
	
	private $_password;
	
	private $_options;
	
	public function __construct() {
		
		$this->_dsn = ICF_Setting::DSN;
		
		$this->_username = ICF_Setting::DB_USERNAME;

		$this->_password = ICF_Setting::DB_PASSWORD;
		
		$this->_options = array();
	}
	
	/**
	 * @return the $_dsn
	 */
	public function getDsn() {
		return $this->_dsn;
	}

	/**
	 * @return the $_username
	 */
	public function getUsername() {
		return $this->_username;
	}

	/**
	 * @return the $_password
	 */
	public function getPassword() {
		return $this->_password;
	}

	/**
	 * @return the $_options
	 */
	public function getOptions() {
		return $this->_options;
	}
	
}

?>