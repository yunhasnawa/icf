<?php

namespace ICF\Core;

class Route
{
	private $routeData;
	private $uri;
	private $class;
	
	public function __construct(array $routeData)
	{
		$this->routeData = $routeData;
		
		$this->retrieveUrl();
		$this->retrieveClass();
	}
	
	public function retrieveUrl()
	{
		$this->uri = $this->routeData['uri'];
	}
	
	public function retrieveClass()
	{
		$this->class = $this->routeData['class'];
	}
	
	public function getUri()
	{
		return $this->uri;
	}
	
	public function getClass()
	{
		return $this->class;
	}
}

?>