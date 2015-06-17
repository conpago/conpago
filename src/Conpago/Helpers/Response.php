<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-19
	 * Time: 23:54
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\Helpers\Contract\IResponse;

	class Response implements IResponse
	{

		function setHttpResponseCode($code)
		{
			http_response_code($code);
		}
	}