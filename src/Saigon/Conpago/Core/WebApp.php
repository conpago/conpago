<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Core;

	use Saigon\Conpago\IApp;
	use Saigon\Conpago\IController;
	use Saigon\Conpago\IRequestDataReader;

	/**
	 * Class WebApp
	 * Main application class.
	 *
	 * @package Saigon\Conpago\Core
	 */
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

		public function __construct(IRequestDataReader $requestDataReader, IController $controller)
		{
			$this->requestDataReader = $requestDataReader;
			$this->controller = $controller;
		}

		/**
		 * Process the request, and generate output
		 */
		public function run()
		{
			try
			{
				$this->executeController($this->getRequestData());
			}
			catch (\Exception $e)
			{
				http_response_code(500);
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
