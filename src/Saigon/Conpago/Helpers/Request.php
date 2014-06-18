<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\Helpers\Contract\IRequest;
	use Saigon\Conpago\Accessor\ServerAccessor;

	class Request implements IRequest
	{
		private $server;

		function __construct()
		{
			$this->server = new ServerAccessor();
		}

		private function getValue($name)
		{
			if (!$this->server->contains($name))
				return null;

			return $this->server->getValue($name);
		}

		function getRequestMethod()
		{
			return $this->getValue('REQUEST_METHOD');
		}

		function getPathInfo()
		{
			return $this->getValue('PATH_INFO');
		}

		function getQueryString()
		{
			return $this->getValue('QUERY_STRING');
		}

		function getContentType()
		{
			return $this->getValue('CONTENT_TYPE');
		}

		function getBody()
		{
			return file_get_contents("php://input");
		}
	}