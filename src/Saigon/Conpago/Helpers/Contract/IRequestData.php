<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-18
	 * Time: 23:26
	 */

	namespace Saigon\Conpago\Helpers\Contract;

	interface IRequestData
	{
		/**
		 * @return array
		 */
		function getUrlElements();

		/**
		 * @return string
		 */
		function getRequestMethod();

		/**
		 * @return array
		 */
		function getParameters();

		/**
		 * @return string
		 */
		function getFormat();
	}