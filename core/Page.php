<?php

namespace ICF\Core;

class Page
{
	private $pageData;
	private $uri;
	private $controller;
	private $html;
	
	public function __construct(array $pageData)
	{
		$this->pageData = $pageData;
		
		$this->retrieveUri();
		$this->retrieveController();
		$this->retrieveHtml();
	}
	
	private function retrieveUri()
	{
		$this->uri = $this->pageData['uri'];
	}
	
	private function retrieveController()
	{
		$this->controller = $this->pageData['controller'];
	}
	
	private function retrieveHtml()
	{
		$this->html = $this->pageData['html'];
	}
	
	private function controllerFilePath($applicationPath)
	{
		$controllerPath = $applicationPath . "/controller";
		
		$controllerFilePath = "$controllerPath/{$this->controller}.php";
		
		return $controllerFilePath;
	}
	
	// Getters
	
	public function getUri()
	{
		return $this->uri;
	}
	
	public function getClass()
	{
		return $this->class;
	}
	
	public function getHtml()
	{
		return $this->html;
	}
	
	// Publics
	public function open(Application $application)
	{
		$controllerNamespace = $application->getNamespace() . '\\Controller\\';
		
		$controllerName = $controllerNamespace . $this->controller;
		
		$controller = new $controllerName($application, $this);
		
		$controller->initialize();
	}
}

?>