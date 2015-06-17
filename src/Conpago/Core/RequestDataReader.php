<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 25.02.14
	 * Time: 07:51
	 */

	namespace Saigon\Conpago\Core;

	use Saigon\Conpago\Helpers\Contract\IRequestData;
	use Saigon\Conpago\Helpers\Contract\IRequestDataReader;
	use Saigon\Conpago\Helpers\Contract\IRequestParser;

	class RequestDataReader implements IRequestDataReader
	{
		/**
		 * @param IRequestParser $requestParser
		 */
		public function __construct(
			IRequestParser $requestParser)
		{
			$this->requestParser = $requestParser;
		}

		/**
		 * @return IRequestData
		 */
		public function getRequestData()
		{
			return $this->requestParser->parseRequestData();
		}

		/**
		 * @var IRequestParser
		 */
		private $requestParser;
	}