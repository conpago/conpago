<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Core;

	use Saigon\Conpago\Config\Contract\IAppConfig;
	use Saigon\Conpago\DI\Factory;
	use Saigon\Conpago\Helpers\Contract\IRequestDataReader;
	use Saigon\Conpago\Presentation\Contract\IController;
	use Saigon\Conpago\Presentation\Contract\IControllerResolver;

	class ControllerResolver implements IControllerResolver
	{
		/**
		 * @var \Saigon\Conpago\Config\Contract\IAppConfig
		 */
		private $appConfig;

		/**
		 * @param IRequestDataReader $requestDataReader
		 * @param IAppConfig $appConfig
		 * @param Factory[] $controllerFactories
		 *
		 * @inject Factory <\Saigon\Conpago\IController> $controllerFactories
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
			$useCaseName = isset($params['use_case'])
				? $params['use_case']
				: $this->appConfig->getDefaultUseCase();

			return $this->controllerFactories[$useCaseName.'Controller']->createInstance();
		}

		/**
		 * @var Factory[]
		 */
		protected $controllerFactories;

		/**
		 * @var IRequestDataReader
		 */
		private $requestDataReader;
	}