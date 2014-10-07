<?php

namespace ICF\Core;

use ICF\Core\Config;
use ICF\Component\View;

require_once 'icf/icf.php';

class Engine
{
	private static $instance;
	
	private $config;
	
	private function __construct()
	{	
		$this->config = Config::getInstance();
	}
	
	public function start()
	{
		$currentUri = \ICF::currentUri();
		
		$currentApplicationId = $this->currentApplicationId($currentUri);
		
		$application = $this->findApplication($currentApplicationId);
		
		if($application != null)
		{
			$application->run($currentUri);
		}
		else 
		{
			View::render404();
		}
	}
	
	private function currentApplicationId($currentUri)
	{
		$explode = explode('/', $currentUri);
		
		// $explode contains: array('', 'pageName', ...) -> take index #1
		if(count($explode) > 1)
		{
			return $explode[1];
		}
		
		return null;
	}
	
	public static function getInstance()
	{
		if(Engine::$instance == null)
		{
			Engine::$instance = new Engine();
		}
		
		return Engine::$instance;
	}
	
	private function findApplication($currentApplicationId)
	{
		foreach ($this->config->getApplications() as $application)
		{
			if($application->getId() == $currentApplicationId)
			{
				return $application;
			}
		}
		
		return null;
	}
}

?>