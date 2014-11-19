<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\Helpers\Contract\IFileSystem;
	use Saigon\Conpago\Helpers\Contract\IRequest;
	use Saigon\Conpago\Utils\ServerAccessor;

	class Request implements IRequest
	{
		private $server;
		/**
		 * @var IFileSystem
		 */
		private $fileSystem;

		/**
		 * @param ServerAccessor $serverAccessor
		 * @param IFileSystem $fileSystem
		 */
		function __construct(ServerAccessor $serverAccessor, IFileSystem $fileSystem)
		{
			$this->server = $serverAccessor;
			$this->fileSystem = $fileSystem;
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
			return $this->fileSystem->getFileContent("php://input");
		}
	}