<?php

namespace framework\icf\main;

class ICF_Globals {
	
	/**
	 * Single object of Database_Access allowing only one instance
	 * per run
	 * 
	 * @var Database_Access
	 */
	public static $DATABASE_ACCESS = null;
	public static $VIEW            = null;
	public static $AUTH            = null;
	public static $BROWSER_URL     = null;
}

?>