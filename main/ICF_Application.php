<?php
/**
 * @author Yoppy Yunhasnawa
 * @copyright 2011
 */
namespace framework\icf\main;

use framework\icf\library\Base;

class ICF_Application extends ICF_Object
{
    private $_url;
    private $_controllerName;
    private $_methodName; // $controller's method
    private $_route;
    private $_args;
    private $_subdomain;
    
    public function __construct($url, $route) 
    {
    	parent::__construct();
    	
        $this->_url       = strtolower($url);
        $this->_route     = $route;
        $this->_args      = array();
        $this->_subdomain = ''; // FIXME: Not all field constructed
        
        $this->checkRoute();
        
        $filename = Base::site_dir('controller/' . $this->_controllerName . '.php');
        //echo Base::site_dir(), "<br/>";
        if(!is_file($filename)) die('Sorry, controller file not found!');
        
        require_once $filename;
        
    }
    
    public function execute() 
    {
        $cn = $this->_controllerName;
        $mn = $this->_methodName;
        
        $controller = new $cn();
        
        $request = array(
        	'post' => $_POST,
        	'get'  => $_GET
        );
        
        $controller->$mn($this->_args, $request);
    }
    
    private function checkRoute() 
    {
    	$noQueryUrl  = $this->_cutQueryUrl($this->_url);
    	$noSubdomain = $this->_cutSubdomain($noQueryUrl);
    	$request     = str_replace(Base::site_url('/'), '', $noSubdomain);
        
        $found = false;
        
        foreach($this->_route as $path => $class) {

			if(empty($path) && empty($request)){
                $found = true;
                break;
			} elseif(!empty($path)) {
				//echo $path, " vs ", $request, "<br/>";
				if(strpos($path, $request) !== false) {
					$this->_proccessArgs($request, $path);
					$found = true;
					break;
				}
			}
        }
        
        if(!$found) die('Sorry, path not found!');
        else {

        	$this->_controllerName = $class[0];
        	
        	$this->_methodName     = $class[1];
        	
        }
        
    }
    
    private function _cutSubdomain($url)
    {
    	$expl = explode('.', $url);
    
    	$urlNew = '';
    
    	if(count($expl) > 2) {
    	  
    		$urlNew .= $expl[1] . '.'  . $expl[2];
    		
    		$subdomain = $expl[0];
    		
    		$this->_subdomain = $subdomain;
    	  
    	} else $urlNew = $url;
    
    	return $urlNew;
    }
    
    private function _cutQueryUrl($url)
    {
    	$delimiter = strpos($url, '?') !== false ? '?' : '&';
    	
    	$expl = explode($delimiter, $url);
    	
    	return $expl[0];
    }
    
    private function _proccessArgs($request, $path)
    {
    	$strArgs = str_replace($path, '', $request);
    	
    	if(!empty($strArgs)) {
    	
	    	if($strArgs[0] == '/') $strArgs = substr($strArgs, 1);
	    	
	    	$args = explode('/', $strArgs);
	    	
	    	$this->_args = $args;
    	
    	}
    }
}

?>