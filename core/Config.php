<?php

namespace ICF\Core;

class Config
{
	private $configData;
	private $aplications;
	
	public function __construct()
	{
		$this->retrieveConfigData();
		$this->retrieveApplications();
	}
	
	private function retrieveConfigData()
	{
		require_once 'icf/support/config_data.php';
		
		$this->configData = $config_data;
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