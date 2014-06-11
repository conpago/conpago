<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Core;

	use DI\Factory;
	use Saigon\Conpago\IRequestDataReader;
	use Saigon\Conpago\IControllerResolver;

	class ControllerResolver implements IControllerResolver
	{

		/**
		 * @param IRequestDataReader $requestDataReader
		 * @param Factory[] $controllerFactories
		 *
		 * @inject Factory <\Saigon\Conpago\IController> $controllerFactories
		 */
		public function __construct(IRequestDataReader $requestDataReader, array $controllerFactories)
		{
			$this->controllerFactories = $controllerFactories;
			$this->requestDataReader = $requestDataReader;
		}

		/**
		 * @return \Saigon\Conpago\IController
		 */
		public function getController()
		{
			$params = $this->requestDataReader->getRequestData()->getParameters();

			return $this->controllerFactories[$params['use_case'] . 'Controller']->createInstance();
		}

		/**
		 * @var \DI\Factory[]
		 */
		protected $controllerFactories;

		/**
		 * @var \Saigon\Conpago\IRequestDataReader
		 */
		private $requestDataReader;
	}