<?php

namespace ICF\Core;

use ICF\Component\View;
class Application
{
	private $applicationData;
	private $id;
	private $name;
	private $pages;
	private $directory;
	
	public function __construct(array $applicationData)
	{
		$this->applicationData = $applicationData;
		
		$this->retrieveId();
		$this->retrieveName();
		$this->retrievePages();
		$this->retrieveDirectory();
	}
	
	private function retrieveId()
	{
		$this->id = $this->applicationData['id'];
	}
	
	private function retrieveName()
	{
		$this->name = $this->applicationData['name'];
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
			$pageUri = $page->getUri();
			
			if($pageUri === $currentUri)
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
			$page->open();
		}
		else 
		{
			View::render404();
		}
	}
}

?>