<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-19
	 * Time: 23:53
	 */

	namespace Saigon\Conpago\Helpers\Contract;

	interface IResponse
	{
		function setHttpResponseCode($code);
	}