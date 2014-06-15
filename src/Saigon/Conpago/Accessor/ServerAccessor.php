<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-15
	 * Time: 12:09
	 */

	namespace Saigon\Conpago\Helpers;

	/**
	 * Class Server
	 *
	 * @package Saigon\Conpago\Accessor
	 *
	 * @SuppressWarnings(PHPMD)
	 */
	class ServerAccessor
	{
		/**
		 * @param $key
		 *
		 * @return bool
		 */
		function contains($key)
		{
			return $_SERVER != null && array_key_exists($key, $_SERVER);
		}

		function getValue($key)
		{
			return $_SERVER[$key];
		}
	}