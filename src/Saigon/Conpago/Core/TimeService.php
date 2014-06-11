<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-10
	 * Time: 20:20
	 */

	namespace Saigon\Conpago\Core;

	use DateTime;
	use Saigon\Conpago\ITimeService;

	class TimeService implements ITimeService
	{
		/**
		 * @return DateTime
		 */
		function getCurrentTime()
		{
			return new DateTime('now');
		}
	}