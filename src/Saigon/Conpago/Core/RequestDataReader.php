<?php
	/**
	 * Created by PhpStorm.
	 * User: bartosz.golek
	 * Date: 25.02.14
	 * Time: 07:51
	 */

	namespace Saigon\Conpago\Core;

	use Saigon\Conpago\Helpers\IRequestParser;
	use Saigon\Conpago\IAppConfig;
	use Saigon\Conpago\IRequestDataReader;

	class RequestDataReader implements IRequestDataReader
	{
		/**
		 * @param IRequestParser $requestParser
		 * @param \Saigon\Conpago\IAppConfig $config
		 */
		public function __construct(
			IRequestParser $requestParser,
			IAppConfig $config)
		{
			$this->requestParser = $requestParser;
			$this->config = $config;
		}

		/**
		 * @return \Saigon\Conpago\RequestData
		 */
		public function getRequestData()
		{
			$requestData = $this->requestParser->parseRequestData();
			$parameters = $requestData->getParameters();
			if (!isset($parameters['use_case']))
			{
				$parameters['use_case'] = $this->config->getDefaultUseCase();
				$requestData->setParameters($parameters);
			}

			return $requestData;
		}

		/**
		 * @var IRequestParser
		 */
		private $requestParser;
		/**
		 * @var \Saigon\Conpago\IAppConfig
		 */
		private $config;
	}