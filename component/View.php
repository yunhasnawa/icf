<?php

namespace ICF\Component;

class View
{
	public function __construct()
	{
		
	}
	
	public static function render404()
	{
		echo "HTTP Error 404: Page not found!";
	}
}