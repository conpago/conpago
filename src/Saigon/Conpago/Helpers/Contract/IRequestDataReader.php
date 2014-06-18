<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 25.02.14
	 * Time: 07:55
	 */

	namespace Saigon\Conpago\Helpers\Contract;


	interface IRequestDataReader
	{
		/**
		 * @return IRequestData
		 */
		function getRequestData();
	}