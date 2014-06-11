<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Utils;

	class String
	{

		/**
		 * @param string $string
		 *
		 * @return bool
		 */
		public static function IsNullOrEmpty($string)
		{
			return $string == null || $string == String::EmptyString;
		}

		/**
		 * @val string
		 */
		const EmptyString = "";
	}