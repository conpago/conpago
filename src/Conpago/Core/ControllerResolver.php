<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Conpago\Core;

	use Conpago\Config\Contract\IAppConfig;
	use Conpago\DI\IFactory;
	use Conpago\Exceptions\ControllerNotFoundException;
	use Conpago\Helpers\Contract\IRequestDataReader;
	use Conpago\Presentation\Contract\IController;
	use Conpago\Presentation\Contract\IControllerResolver;

	class ControllerResolver implements IControllerResolver
	{
		/**
		 * @var \Conpago\Config\Contract\IAppConfig
		 */
		private $appConfig;

		/**
		 * @param IRequestDataReader $requestDataReader
		 * @param IAppConfig $appConfig
		 * @param IFactory[] $controllerFactories
		 *
		 * @inject Factory <\Conpago\IController> $controllerFactories
		 */
		public function __construct(IRequestDataReader $requestDataReader, IAppConfig $appConfig, array $controllerFactories)
		{
			$this->controllerFactories = $controllerFactories;
			$this->requestDataReader = $requestDataReader;
			$this->appConfig = $appConfig;
		}

		/**
		 * @return IController
		 */
		public function getController()
		{
			$params = $this->requestDataReader->getRequestData()->getParameters();
			$controllerName = isset($params['interactor'])
				? $params['interactor']
				: $this->appConfig->getDefaultInteractor();

			$controllerArrayKey = $controllerName . 'Controller';

			if (!array_key_exists($controllerArrayKey, $this->controllerFactories))
				throw new ControllerNotFoundException('Controller \''.$controllerName.'\' not found.');

			return $this->controllerFactories[$controllerArrayKey]->createInstance();
		}

		/**
		 * @var IFactory[]
		 */
		protected $controllerFactories;

		/**
		 * @var IRequestDataReader
		 */
		private $requestDataReader;
	}
