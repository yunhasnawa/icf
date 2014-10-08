<?php

$config_data = array(
	'iujs_directory' => '/iujs',
	'applications'   => array(
		array(
			'id'        => 'us',
			'name'      => 'URL Shortener',
			'directory' => '/urlshortener',
			'pages'     => array(
				array(
					'uri'        => '/us/index.php',
					'controller' => 'Index',
					'html'       => 'index.html'
				),
				array(
					'uri'        => '/us/about.php',
					'controller' => 'About',
					'html'       => 'about.html'
				)
			)
		)
	)
);

?>