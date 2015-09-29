<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Conpago\Core;

	use Conpago\Contract\IApp;
	use Conpago\Helpers\Contract\IRequestDataReader;
	use Conpago\Helpers\Contract\IResponse;
	use Conpago\Logging\Contract\ILogger;
	use Conpago\Presentation\Contract\IController;

	class WebApp implements IApp
	{
		/**
		 * @var IController
		 */
		private $controller;

		/**
		 * @var IRequestDataReader
		 */
		private $requestDataReader;
		/**
		 * @var IResponse
		 */
		private $response;
		/**
		 * @var ILogger
		 */
		private $logger;

		public function __construct(
				IRequestDataReader $requestDataReader,
				IController $controller,
				IResponse $response,
				ILogger $logger)
		{
			$this->requestDataReader = $requestDataReader;
			$this->controller = $controller;
			$this->response = $response;
			$this->logger = $logger;
		}

		/**
		 * Process the request, and generate output
		 */
		public function run()
		{
			try
			{
				$this->executeController();
			}
			catch (\Exception $e)
			{
				$this->logger->addCritical('Exception caught', array('exception' => $e));
				$this->response->setHttpResponseCode(500);
			}
		}

		private function getRequestData()
		{
			return $this->requestDataReader->getRequestData();
		}

		private function executeController()
		{
			$this->controller->execute($this->getRequestData());
		}
	}
