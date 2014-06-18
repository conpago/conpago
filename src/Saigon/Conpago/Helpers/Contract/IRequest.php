<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers\Contract;

	interface IRequest
	{
		function getRequestMethod();

		function getPathInfo();

		function getQueryString();

		function getContentType();

		function getBody();
	}