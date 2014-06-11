<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers;

	class Path
	{
		public static function createPath($elements = null)
		{
			$elements = func_get_args();

			return implode(DIRECTORY_SEPARATOR, $elements);
		}
	}