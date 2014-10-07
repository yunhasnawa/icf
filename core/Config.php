<?php

namespace ICF\Core;

class Config
{
	private static $instance;
	
	private $configData;
	private $iujsDirectory;
	private $aplications;
	
	private function __construct()
	{
		$this->retrieveConfigData();
		$this->retrieveIujsDirectory();
		$this->retrieveApplications();
	}
	
	private function retrieveConfigData()
	{
		require_once 'icf/support/config_data.php';
		
		$this->configData = $config_data;
	}
	
	private function retrieveIujsDirectory()
	{
		$this->iujsDirectory = $this->configData['iujs_directory'];
	}
	
	private function retrieveApplications()
	{
		$this->aplications = array();
		
		$applicationsData = $this->configData['applications'];
		
		foreach ($applicationsData as $applicationData)
		{
			$this->aplications[] = new Application($applicationData);
		}
	}
	
	// Getters
	public function getConfigData()
	{
		return $this->configData;
	}
	
	public function getApplications()
	{
		return $this->aplications;
	}
	
	public function getIujsDirectory()
	{
		return $this->iujsDirectory;
	}
	
	public static function getInstance()
	{
		if(Config::$instance == null)
		{
			Config::$instance = new Config();
		}
		
		return Config::$instance;
	}
	
	// Publics
	public function availableUris()
	{
		$uris = array();
		
		foreach ($this->aplications as $application)
		{
			foreach ($application->getPages() as $page)
			{
				$uris[] = $page->getUri();
			}
		}
		
		return $uris;
	}
}

?>