<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-18
	 * Time: 23:32
	 */
	namespace Saigon\Conpago\Helpers\Contract;

	interface IArgs
	{
		public function getArguments();

		public function getScript();

		/**
		 * @param string $option
		 *
		 * @return string
		 */
		public function getOption($option);

		/**
		 * @param string $option
		 *
		 * @return bool
		 */
		public function hasOption($option);
	}