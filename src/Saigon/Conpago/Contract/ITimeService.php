<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-10
	 * Time: 20:19
	 */

	namespace Saigon\Conpago;

	use DateTime;

	interface ITimeService
	{
		/**
		 * @return DateTime
		 */
		function getCurrentTime();
	}