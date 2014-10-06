<?php

function __autoload($className)
{
	$className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    
    $lastNsPos = strrpos($className, '\\');
    
    if ($lastNsPos) 
    {
        $namespace = substr($className, 0, $lastNsPos);
        
        $className = substr($className, $lastNsPos + 1);
        
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    
    require $fileName;
}

class ICF
{
	private static $instance;
	
	private $rootDirectory;
	
	private function __construct()
	{
		$this->retrieveRootDirectory();
	}
	
	private function retrieveRootDirectory()
	{
		$this->rootDirectory = $current = dirname(__DIR__);
	}
	
	private function getInstance()
	{
		if(ICF::$instance == null)
		{
			ICF::$instance = new ICF();
		}
		
		return ICF::$instance;
	}
	
	public static function getRootDirectory()
	{
		return ICF::getInstance()->rootDirectory;
	}
	
	public static function frameworkDirectory()
	{
		return ICF::getRootDirectory() . '/icf';
	}

	public static function currentUri()
	{
		$uri = $_SERVER['REQUEST_URI'];
	
		$clearUri = \ICF::clearUri($uri);
	
		return $clearUri;
	}
	
	public static function clearUri($uri)
	{
		$explode = explode('?', $uri);
		
		if(count($explode) > 0)
		{
			return $explode[0];
		}
		else 
		{
			return $uri;
		}
	}
}