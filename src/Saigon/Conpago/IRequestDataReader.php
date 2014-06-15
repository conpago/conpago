<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 25.02.14
	 * Time: 07:55
	 */

	namespace Saigon\Conpago;


	interface IRequestDataReader
	{
		/**
		 * @return \Saigon\Conpago\RequestData
		 */
		function getRequestData();
	}