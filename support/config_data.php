<?php

$config_data = array(
	'applications' => array(
		array(
			'id'        => 'us',
			'name'      => 'URL Shortener',
			'namespace' => 'Urlshortener',
			'directory' => '/urlshortener',
			'pages'     => array(
				array(
					'uri'        => '/us/index.php',
					'controller' => 'Index',
					'method'     => 'index',
					'html'       => 'index.html'
				)
			)
		)
	)
);

?>