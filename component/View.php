<?php

namespace ICF\Component;

class View
{
	private $applicationDirectory;
	private $viewPath;
	private $templateFile;
	private $templatePath;
	private $template;
	private $htmlFile;
	private $htmlPath;
	private $html;
	
	const BODY_HTML_PLACEHOLDER = '<!--body_html-->';
	
	public function __construct($applicationDirectory, $htmlFile)
	{
		$this->applicationDirectory = $applicationDirectory;
		$this->htmlFile             = $htmlFile;
		$this->templateFile         = 'template.html';
		
		$this->retrieveViewPath();
		$this->retrieveTemplatePath();
		$this->retrieveTemplate();
		$this->retrieveHtmlPath();
		$this->retrieveHtml();
	}
	
	private function retrieveViewPath()
	{
		$root = \ICF::getRootDirectory();
		
		$path = "$root{$this->applicationDirectory}/view";
		
		$this->viewPath = $path;
	}
	
	private function retrieveTemplatePath()
	{
		$path = "{$this->viewPath}/{$this->templateFile}";
		
		$this->templatePath = $path;
	}
	
	private function retrieveTemplate()
	{
		$this->template = file_get_contents($this->templatePath);
	}
	
	private function retrieveHtmlPath()
	{	
		$path = "{$this->viewPath}/{$this->htmlFile}";
		
		$this->htmlPath = $path;
	}

	private function retrieveHtml()
	{
		$this->html = file_get_contents($this->htmlPath);
	}
	
	public function getViewPath()
	{
		return $this->viewPath;
	}
	
	public function render(array $data)
	{
		$htmlString = $this->template;
		
		$htmlString = str_replace(View::BODY_HTML_PLACEHOLDER, $this->html, $htmlString);
		
		echo $htmlString;
	}
	
	public static function render404()
	{
		echo "HTTP Error 404: Page not found!";
	}
}