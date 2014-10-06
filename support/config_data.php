<?php

$config_data = array(
	'applications' => array(
		array(
			'name'      => 'URL Shortener',
			'directory' => '/urlshortener',
			'routes'    => array(
				array(
					'uri'   => '/us/index.php',
					'class' => 'Index',
				)
			)
		)
	)
);

?>