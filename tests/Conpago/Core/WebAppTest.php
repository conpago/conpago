<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-19
 * Time: 23:46
 */

namespace Conpago\Core;

class WebAppTest extends \PHPUnit_Framework_TestCase
{
    protected $controller;

    protected $logger;

    protected $response;

    protected $appConfig;

    protected $requestDataReader;

    protected $webApp;

    public function testHttp500ErrorOnExceptionFromRequestDataReader()
    {
        $this->response->expects($this->once())->method('setHttpResponseCode')->with(500);
        $this->requestDataReader->expects($this->any())->method('getRequestData')->willThrowException(new \Exception());

        $this->webApp->run();
    }

    public function testSettingTimeZoneWithoutError()
    {
        $this->assertNotEquals('Europe/Warsaw', date_default_timezone_get());
        $this->appConfig->expects($this->any())->method('getTimeZone')->willReturn('Europe/Warsaw');
        $this->webApp->run();
        $this->assertEquals('Europe/Warsaw', date_default_timezone_get());
    }

    public function testHttp500ErrorOnExceptionFromController()
    {
        $requestData = $this->getMock('Conpago\Helpers\Contract\IRequestData');
        $this->response->expects($this->once())->method('setHttpResponseCode')->with(500);
        $this->requestDataReader->expects($this->any())->method('getRequestData')->willReturn($requestData);
        $this->controller->expects($this->once())->method('execute')->willThrowException(new \Exception());

        $this->webApp->run();
    }

    public function testExecuteController()
    {
        $requestData = $this->getMock('Conpago\Helpers\Contract\IRequestData');
        $this->requestDataReader->expects($this->any())->method('getRequestData')->willReturn($requestData);
        $this->controller->expects($this->once())->method('execute')->with($requestData);
        $this->webApp->run();
    }

    public function setUp()
    {
        $this->controller        = $this->getMock('Conpago\Presentation\Contract\IController');
        $this->logger            = $this->getMock('Conpago\Logging\Contract\ILogger');
        $this->response          = $this->getMock('Conpago\Helpers\Contract\IResponse');
        $this->appConfig         = $this->getMock('Conpago\Config\Contract\IAppConfig');
        $this->requestDataReader = $this->getMock('Conpago\Helpers\Contract\IRequestDataReader');
        $this->webApp            = new WebApp(
            $this->requestDataReader,
            $this->controller,
            $this->response,
            $this->logger,
            $this->appConfig);
    }
}
