<?php

namespace ICF\Core;

use ICF\Component\View;
class Application
{
	private $applicationData;
	private $id;
	private $name;
	private $namespace;
	private $pages;
	private $directory;
	
	public function __construct(array $applicationData)
	{
		$this->applicationData = $applicationData;
		
		$this->retrieveId();
		$this->retrieveName();
		$this->retrievePages();
		$this->retrieveDirectory();
		$this->retrieveNamespace();
	}
	
	private function retrieveId()
	{
		$this->id = $this->applicationData['id'];
	}
	
	private function retrieveName()
	{
		$this->name = $this->applicationData['name'];
	}
	
	private function retrieveNamespace()
	{
		$cleanDirectory = str_replace('/', '', $this->directory);
		
		$this->namespace = ucfirst($cleanDirectory);
	}
	
	private function retrievePages()
	{
		$this->pages = array();
		
		$pagesData = $this->applicationData['pages'];
		
		foreach ($pagesData as $pageData)
		{
			$this->pages[] = new Page($pageData);
		}
	}
	
	private function retrieveDirectory()
	{
		$this->directory = $this->applicationData['directory'];
	}
	
	private function findPage($currentUri)
	{
		foreach ($this->pages as $page)
		{
			if ($page->getUri() === $currentUri)
			{
				return $page;
			}
		}
		
		return null;
	}
	
	// Getters
	public function getPages()
	{
		return $this->pages;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getNamespace()
	{
		return $this->namespace;
	}
	
	public function getDirectory()
	{
		return $this->directory;
	}
	
	// Publics
	public function run($currentUri)
	{
		$page = $this->findPage($currentUri);
		
		if($page != null)
		{
			$page->open($this);
		}
		else 
		{
			View::render404();
		}
	}
	
	public function path($next = null)
	{
		$root = \ICF::getRootDirectory();
		
		$path = "$root{$this->directory}";
		
		if($next != null)
		{
			$path .= "/$next";
		}
	
		return $path;
	}
}

?>