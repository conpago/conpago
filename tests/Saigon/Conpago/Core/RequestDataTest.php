<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-17
	 * Time: 08:03
	 */

	namespace Saigon\Conpago\Core;


	class RequestDataTest extends \PHPUnit_Framework_TestCase
	{
		/**
		 * @var RequestData
		 */
		private $requestData;

		function setUp()
		{
			$this->requestData = new RequestData();
		}

		function testFormat()
		{
			$this->requestData->setFormat('format');
			$this->assertEquals('format', $this->requestData->getFormat());
		}

		function testParameters()
		{
			$this->requestData->setParameters('parameters');
			$this->assertEquals('parameters', $this->requestData->getParameters());
		}

		function testRequestMethod()
		{
			$this->requestData->setRequestMethod('requestMethod');
			$this->assertEquals('requestMethod', $this->requestData->getRequestMethod());
		}

		function testUrlElements()
		{
			$this->requestData->setUrlElements('urlElements');
			$this->assertEquals('urlElements', $this->requestData->getUrlElements());
		}
	}
 