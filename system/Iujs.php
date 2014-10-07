<?php

namespace ICF\System;

use ICF\Core\Config;
class Iujs
{
	public $data;
	public $htmlString;

	private $iujsPath;
	
	public function __construct()
	{
		$this->retrieveIujsPath();
	}
	
	private function retrieveIujsPath()
	{
		$root = \ICF::getRootDirectory();
		
		$directory = Config::getInstance()->getIujsDirectory();
		
		$path = "$root/$directory/iu.js";
		
		$this->iujsPath = $path;
	}
	
	public function integrate()
	{
		return $this->htmlString;
	}
}