<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-15
	 * Time: 23:02
	 */

	namespace Saigon\Conpago\Helpers;

	class RequestParserTest extends \PHPUnit_Framework_TestCase
	{
		function testThrowsBadMethodCallExceptionFor()
		{
			$this->setExpectedException('BadMethodCallException');
			$request = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequest');
			$request->expects($this->any())->method('getContentType')->willReturn('bad content type');

			$requestParser = new RequestParser($request);
			$requestParser->parseRequestData();
		}

		function testEmptyJsonRequest()
		{
			$request = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequest');
			$request->expects($this->any())->method('getContentType')->willReturn('application/json');

			$requestParser = new RequestParser($request);
			$requestData = $requestParser->parseRequestData();

			$this->assertRequestData($requestData, 'json', array(), '', array());
		}

		function testJsonRequestWithUrlElements()
		{
			$request = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequest');
			$request->expects($this->any())->method('getContentType')->willReturn('application/json');
			$request->expects($this->any())->method('getPathInfo')->willReturn('path/info');

			$requestParser = new RequestParser($request);
			$requestData = $requestParser->parseRequestData();

			$this->assertRequestData($requestData, 'json', array(), '', array('path', 'info'));
		}

		function testJsonRequestWithRequestMethod()
		{
			$request = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequest');
			$request->expects($this->any())->method('getContentType')->willReturn('application/json');
			$request->expects($this->any())->method('getRequestMethod')->willReturn('requestMethod');

			$requestParser = new RequestParser($request);
			$requestData = $requestParser->parseRequestData();

			$this->assertRequestData($requestData, 'json', array(), 'requestMethod', array());
		}

		function testJsonRequestWithQueryString()
		{
			$request = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequest');
			$request->expects($this->any())->method('getContentType')->willReturn('application/json');
			$request->expects($this->any())->method('getQueryString')->willReturn('a=1&b=2');

			$requestParser = new RequestParser($request);
			$requestData = $requestParser->parseRequestData();

			$this->assertRequestData($requestData, 'json', array('a' => 1, 'b' => 2), '', array());
		}

		function testJsonRequestWithSimpleBody()
		{
			$request = $this->getMock('Saigon\Conpago\Helpers\Contract\IRequest');
			$request->expects($this->any())->method('getContentType')->willReturn('application/json');
			$request->expects($this->any())->method('getBody')->willReturn(json_encode(array('a' => 1, 'b' => 2)));

			$requestParser = new RequestParser($request);
			$requestData = $requestParser->parseRequestData();

			$this->assertRequestData($requestData, 'json', array('a' => 1, 'b' => 2), '', array());
		}

		/**
		 * @param $requestData
		 * @param $format
		 * @param $parameters
		 * @param $requestMethod
		 * @param $urlElements
		 */
		protected function assertRequestData($requestData, $format, $parameters, $requestMethod, $urlElements)
		{
			$this->assertEquals(array(
					'getFormat' => $format,
					'getParameters' => $parameters,
					'getRequestMethod' => $requestMethod,
					'getUrlElements' => $urlElements
				),
				array(
					'getFormat' => $requestData->getFormat(),
					'getParameters' => $requestData->getParameters(),
					'getRequestMethod' => $requestData->getRequestMethod(),
					'getUrlElements' => $requestData->getUrlElements()
				));
		}
	}
