<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-19
	 * Time: 23:46
	 */

	namespace Saigon\Conpago\Core;

	class WebAppTest extends \PHPUnit_Framework_TestCase
	{
		public function testHttp500ErrorOnExceptionFromRequestDataReader()
		{
			$controller = $this->getMock('Saigon\Conpago\Presentation\Contract\IController');
			$response = $this->getMock('Saigon\Conpago\Helpers\Contract\IResponse');
			$response->expects($this->once())->method('setHttpResponseCode')->with(500);

			$requestDataReader = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequestDataReader');
			$requestDataReader->expects($this->any())->method('getRequestData')->willThrowException(new \Exception());

			$webApp = new WebApp($requestDataReader, $controller, $response);
			$webApp->run();
		}

		public function testHttp500ErrorOnExceptionFromController()
		{
			$response = $this->getMock('Saigon\Conpago\Helpers\Contract\IResponse');
			$response->expects($this->once())->method('setHttpResponseCode')->with(500);

			$requestDataReader = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequestDataReader');
			$requestData = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequestData');
			$requestDataReader->expects($this->any())->method('getRequestData')->willReturn($requestData);

			$controller = $this->getMock('Saigon\Conpago\Presentation\Contract\IController');
			$controller->expects($this->once())->method('execute')->willThrowException(new \Exception());

			$webApp = new WebApp($requestDataReader, $controller, $response);
			$webApp->run();
		}

		public function testExecuteController()
		{
			$response = $this->getMock('Saigon\Conpago\Helpers\Contract\IResponse');

			$requestDataReader = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequestDataReader');
			$requestData = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequestData');
			$requestDataReader->expects($this->any())->method('getRequestData')->willReturn($requestData);

			$controller = $this->getMock('Saigon\Conpago\Presentation\Contract\IController');
			$controller->expects($this->once())->method('execute')->with($requestData);

			$webApp = new WebApp($requestDataReader, $controller, $response);
			$webApp->run();
		}
	}
