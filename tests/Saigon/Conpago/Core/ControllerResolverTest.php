<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-19
	 * Time: 23:17
	 */

	namespace Saigon\Conpago\Core;

	class ControllerResolverTest extends \PHPUnit_Framework_TestCase
	{
		public $requestData;
		private $requestDataReader;

		private $appConfig;

		private $controllerFactories = array();

		public function setUp()
		{
			$this->requestDataReader = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequestDataReader');
			$this->appConfig = $this->getMock('Saigon\Conpago\Config\Contract\IAppConfig');
			$this->requestData = $this->getMock('Saigon\Conpago\Core\RequestData');

			$this->requestDataReader->expects($this->any())
				->method('getRequestData')->willReturn($this->requestData);
		}

		public function testNotExistingController()
		{
			$this->setExpectedException('Saigon\Conpago\Exceptions\ControllerNotFoundException', 'Controller \'\' not found.');
			$controllerResolver = new ControllerResolver(
				$this->requestDataReader,
				$this->appConfig,
				$this->controllerFactories);

			$controllerResolver->getController();
		}

		public function testNonDefaultInteractorController()
		{
			$this->appConfig->expects($this->any())
				->method('getDefaultInteractor')
				->willReturn('default');

			$this->requestData->expects($this->once())->method('getParameters')->willReturn(array('interactor' => 'nonDefault'));

			$controller = $this->getMock('Saigon\Conpago\IController');

			$commandFactory = $this->getMock('Saigon\Conpago\DI\IFactory');
			$commandFactory->expects($this->once())->method('createInstance')->willReturn($controller);

			$this->controllerFactories['nonDefaultController'] = $commandFactory;

			$controllerResolver = new ControllerResolver(
				$this->requestDataReader,
				$this->appConfig,
				$this->controllerFactories);

			$this->assertEquals($controller, $controllerResolver->getController());
		}

		public function testDefaultInteractorController()
		{
			$this->appConfig->expects($this->any())
				->method('getDefaultInteractor')
				->willReturn('default');

			$controller = $this->getMock('Saigon\Conpago\IController');

			$commandFactory = $this->getMock('Saigon\Conpago\DI\IFactory');
			$commandFactory->expects($this->once())->method('createInstance')->willReturn($controller);

			$this->controllerFactories['defaultController'] = $commandFactory;

			$controllerResolver = new ControllerResolver(
				$this->requestDataReader,
				$this->appConfig,
				$this->controllerFactories);

			$this->assertEquals($controller, $controllerResolver->getController());
		}
	}
