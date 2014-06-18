<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 27.11.13
	 * Time: 19:20
	 */

	namespace Saigon\Conpago\Logging\Contract;

	class LogLevels
	{

		/**
		 * Detailed debug information
		 */
		const DEBUG = 100;

		/**
		 * Interesting events
		 *
		 * Examples: User logs in, SQL logs.
		 */
		const INFO = 200;

		/**
		 * Uncommon events
		 */
		const NOTICE = 250;

		/**
		 * Exceptional occurrences that are not errors
		 *
		 * Examples: Use of deprecated APIs, poor use of an API,
		 * undesirable things that are not necessarily wrong.
		 */
		const WARNING = 300;

		/**
		 * Runtime errors
		 */
		const ERROR = 400;

		/**
		 * Critical conditions
		 *
		 * Example: Application component unavailable, unexpected exception.
		 */
		const CRITICAL = 500;

		/**
		 * Action must be taken immediately
		 *
		 * Example: Entire website down, database unavailable, etc.
		 * This should trigger the SMS alerts and wake you up.
		 */
		const ALERT = 550;

		/**
		 * Urgent alert.
		 */
		const EMERGENCY = 600;

	}