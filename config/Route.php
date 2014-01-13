<?php

namespace icf\config;

class Route
{
	public static function get()
	{
		return array(
			'jayuz_api' => array(
				'user/register' => array('User' => 'register'),
			)
		);
	}
}