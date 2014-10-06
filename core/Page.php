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
		
		$this->retrieveUrl();
		$this->retrieveClass();
		$this->retrieveHtml();
	}
	
	public function retrieveUrl()
	{
		$this->uri = $this->pageData['uri'];
	}
	
	public function retrieveClass()
	{
		$this->controller = $this->pageData['controller'];
	}
	
	public function retrieveHtml()
	{
		$this->html = $this->pageData['html'];
	}
	
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
	public function open()
	{
		echo "This is the page you looking for..";
	}
}

?>