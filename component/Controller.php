<?php

namespace ICF\Component;

use ICF\Core\Application;
use ICF\Core\Page;
class Controller
{
	protected $application;
	protected $page;
	protected $view;
	
	public function __construct(Application $application, Page $page)
	{
		$this->application = $application;
		$this->page        = $page;
		
		$this->retrieveView();
	}
	
	private function retrieveView()
	{
		$this->view = new View($this->application->getDirectory(), $this->page->getHtml());
	}
	
	public function initialize()
	{
		
	}
	
	public function viewDidLoad($viewData)
	{
		
	}
}