<?php

namespace ICF\Core;

use ICF\Core\Config;

require_once 'icf/icf.php';

class Engine
{
	private static $instance;
	
	private $config;
	
	private function __construct()
	{	
		$this->config = new Config();
	}
	
	public function start()
	{
		$currentUri = \ICF::currentUri();
		
		$application = $this->findApplication($currentUri);
		
		if($application != null)
		{
			$application->run();
		}
		else 
		{
			echo '404 -> URL Not Found!';
		}
	}
	
	public static function getInstance()
	{
		if(Engine::$instance == null)
		{
			Engine::$instance = new Engine();
		}
		
		return Engine::$instance;
	}
	
	private function findApplication($currentUri)
	{
		$uris = $this->config->availableUris();
		
		$index = 0;
		$found = false;
		
		foreach ($uris as $uri)
		{	
			if($uri === $currentUri)
			{
				$found = true;
				
				break;
			}
			
			$index++;
		}
		
		$application = null;
		
		if($found)
		{
			$applications = $this->config->getApplications();
			
			$application = $applications[$index];
		}
		
		return $application;
	}
}

?>