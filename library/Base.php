<?php
/**
 * @author Yoppy Yunhasnawa
 * @copyright 2011
 */

namespace icf\library;

require_once 'icf/main/ICF_Setting.php';

use icf\main\ICF_Setting;
use icf\main\ICF_Constants;
use icf\main\ICF_Globals;

class Base 
{
	public static function redirect($url, $javascriptRedirection = true) 
	{	
		$expl = explode('/', Base::site_url());
		
		$rootUrl = $expl[0];
		
		$url = str_replace($rootUrl, '', $url);
		
		if(!$javascriptRedirection) {
			header ( "location:$url" );
		} else {
			echo '<script>location.href="'.$url.'";</script>';
		}
	}
	
	public static function siteUrl($next = "") {
		
		$slash = Base::getSlash($next, '/');
		
		$settingUrl = ICF_Setting::getInstance()->siteUrl;
		
		//if(strpos($settingUrl, 'http://') === false)
			//$settingUrl = "http://$settingUrl";
		
		$url = $settingUrl . $slash . $next;
		
		//echo ICF_Setting::SITE_URL, " + $slash + ", $next, "<br/>";
		//echo $url, "<br/>";
		//echo "-----------------", "<br/>";//die;
		
		return $url;
	}
	
	public static function arrdeb($variable, $tag = '', $die = false, $insource = false) 
	{	
		if(!empty($tag))
		{
			echo "<h3>$tag</h3>";
		}
		
		if ($insource) 
		{	
			echo '<pre><!--';
			print_r ( $variable );
			echo '--></pre>';
		} 
		else 
		{	
			echo '<pre>';
			print_r ( $variable );
			echo trim ( '</pre>' );
		}
		
		if ($die !== false) 
		{
			die ();
		}
	}
	
	public static function siteDir($next = '')
	{
		$rootDir = ICF_Globals::$SITE_DIR;
		
		if(is_array($next))
		{
			$segments = implode('/', $next);
			
			$completeDir = "$rootDir/$segments";
		}
		else 
		{
			$completeDir = "$rootDir/$next";
		}
		
		return $completeDir;
	}
	
	public static function insertScript($fileName, $echo = true) {
		
		$scriptTag = <<< PHREDOC
		<script type="text/javascript" src="ecma/$fileName.js"></script>
PHREDOC;
		
		if(!$echo) {
			return $scriptTag;
		} else 
			echo $scriptTag;
	
	}
	
	public static function insertStyle($fileName, $echo = true) {
		
		$styleTag = <<< PHREDOC
		<link rel="stylesheet" href="css/$fileName.css" />
PHREDOC;
		
		if(!$echo) {
			return $styleTag;
		} else 
			echo $styleTag;
	}
	
	public static function echoln($string) {
		
		echo $string, "</br>";
		
	}
	
	/**
	 * Find the data of current line caller by using std::debug_backtrace
	 * 
	 * You can fill the parameter with any info which is exists in 
	 * debug_bactrace() return value
	 * 
	 * Usage:
	 * 
	 * find_caller('file-line-class') returns the data within string
	 * like:
	 * "file_name line_number class_name"
	 * 
	 * find_caller('file:line:class') returns the data within array
	 * like:
	 * array(
	 *     'file' => 'file_name', 
	 *     'line' => 'line_number', 
	 *     'class' => 'class_name'
	 * )
	 * 
	 * @param string $subjects the data subject
	 * 
	 * @return string|mixed[] caller data
	 */
	public static function findCaller($subjects = '') {
		
		$subjects = empty($subjects) ? 'file' : $subjects;
		
		$line   = '-';
		$array  = ':';
		
		$separator = '';
		
		if(strpos($subjects, $line) !== false) {
			$separator = $line;
		} elseif (strpos($subjects, $array) !== false) {
			$separator = $array;
		}
		
		$parsedSubject = array();
		
		$parsedSubject = empty($separator) ? array($subjects) : explode($separator, $subjects);
		
		$debugData = debug_backtrace();
		
		$lastStack = $debugData[1];
		
		$callerData = '';
			
		if($separator == $array) {
			
			$callerData = array();
			
			foreach($parsedSubject as $subject) {
				
				$callerData[$subject] = isset($lastStack[$subject]) ? $lastStack[$subject] : "";
			}
			
		} else {
			
			foreach($parsedSubject as $subject) {
				
				$strSubject = isset($lastStack[$subject]) ? $lastStack[$subject] : "";
				
				$callerData .= $strSubject . "\n";
				
			}
		}
		
		return $callerData;
	}
	
	public static function getSlash($next = '', $absoluteSlash = false)
	{
		$slash = '';
		
		// If there is absolute slash given, use the absolute one
		// Absolute slash is useful for URL slash, which is always '/'
		if($absoluteSlash) 
		{
			$slashType = $absoluteSlash;
		} 
		else // Otherwise, check setting
		{
			$slashType = ICF_Setting::getInstance()->serverEnvironment == ICF_Constants::SERVER_ENVIRONMENT_UNIX ?
				'/' : "\\";
		}
		
		// Check next string. If first char is slash, don't add more.
		// This prevent double slash e.g. '//' or '\\'
		// Finally, assign $slashType to $slash and return it.
		if(!empty($next)) 
		{
			$first = $next[0];
			
			if($first !== $slashType) 
			{
				$slash = $slashType;
			}
		}
		else 
		{
			$slash = $slashType;
		}
		
		return $slash;
	}
	
	public static function css($name)
	{
		$cssDir = ICF_Setting::SITE_CSS_DIRECTORY;
		
		$file = Base::site_dir("/$cssDir/$name.css");
		
		$content = file_get_contents($file);
		
		$search  = 'url("';
		$replace = 'url("http://' . Base::site_url();
		
		$css = str_replace($search, $replace, $content);
		
		unset($content);
		
		return <<< PHREDOC
<style type="text/css">
<!--
$css
-->
</style>

PHREDOC;
	}
	
	public static function js($name)
	{
		$jsDir = ICF_Setting::SITE_JAVASCRIPT_DIRECTORY;
		
		$file = Base::site_dir("/$jsDir/$name.js");
		
		$content = file_get_contents($file);
		
		$js = $content;
		
		return <<< PHREDOC
<script type="text/javascript">
<!--
$js
-->
</script>
		
PHREDOC;
	}
	
	public static function strong($str)
	{
		return "<strong>$str</strong>";
	}
	
	public static function spucfirst($string)
	{
		$expl = explode(' ', $string);
		
		$copy = array();
		
		foreach($expl as $word) {
			
			$copy[] = ucfirst($word);
			
		}
		
		unset($expl);
		
		$result = implode(' ', $copy);
		
		unset($copy);
		
		return $result;
	}
	
	public static function savecho(&$var, $default = '', $return = false)
	{
		if(!$return) {
			if(isset($var)) echo $var;
			else echo $default;
		} else {
			if(isset($var)) return $var;
			else return $default;
		}
	}

}

?>