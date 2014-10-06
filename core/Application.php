<?php

namespace ICF\Core;

class Application
{
	private $applicationData;
	private $name;
	private $routes;
	
	public function __construct(array $applicationData)
	{
		$this->applicationData = $applicationData;
		
		$this->retrieveName();
		$this->retrieveRoutes();
	}
	
	private function retrieveName()
	{
		$this->name = $this->applicationData['name'];
	}
	
	private function retrieveRoutes()
	{
		$this->routes = array();
		
		$routesData = $this->applicationData['routes'];
		
		foreach ($routesData as $routeData)
		{
			$this->routes[] = new Route($routeData);
		}
	}
	
	// Getters
	public function getRoutes()
	{
		return $this->routes;
	}
	
	// Publics
	public function run()
	{
		echo "Yaay!! It is running!";
	}
}

?>