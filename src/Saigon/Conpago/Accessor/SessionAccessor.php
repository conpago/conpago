<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-15
	 * Time: 12:51
	 */

	namespace Saigon\Conpago\Accessor;

	/**
	 * Class SessionAccessor
	 *
	 * @package Saigon\Conpago\Accessor
	 *
	 * @SuppressWarnings(PHPMD)
	 */
	class SessionAccessor
	{
		/**
		 * @param $key
		 *
		 * @return bool
		 */
		function contains($key)
		{
			return $_SESSION != null && array_key_exists($key, $_SESSION);
		}

		/**
		 * @param string $name
		 *
		 * @return mixed
		 */
		public function getValue($name)
		{
			return $_SESSION[$name];
		}

		public function setValue($name, $value)
		{
			$_SESSION[$name] = $value;
		}
	}