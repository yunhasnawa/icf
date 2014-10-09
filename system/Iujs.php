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
	
	public static function findViewData()
	{
		$vd = $_GET['vd'];
		
		$unstringify = str_replace('\"', '"', $vd);
		
		$viewData = json_decode($unstringify, true);
		
		return $viewData;
	}
}