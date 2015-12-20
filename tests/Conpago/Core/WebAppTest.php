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
    public function testHttp500ErrorOnExceptionFromRequestDataReader()
    {
        $controller = $this->getMock('Conpago\Presentation\Contract\IController');
        $logger = $this->getMock('Conpago\Logging\Contract\ILogger');
        $response = $this->getMock('Conpago\Helpers\Contract\IResponse');
        $response->expects($this->once())->method('setHttpResponseCode')->with(500);

        $requestDataReader = $this->getMock('Conpago\Helpers\Contract\IRequestDataReader');
        $requestDataReader->expects($this->any())->method('getRequestData')->willThrowException(new \Exception());

        $appConfig = $this->getMock('Conpago\Config\Contract\IAppConfig');

        $webApp = new WebApp($requestDataReader, $controller, $response, $logger, $appConfig);
        $webApp->run();
    }

    public function testHttp500ErrorOnExceptionFromController()
    {
        $logger = $this->getMock('Conpago\Logging\Contract\ILogger');

        $response = $this->getMock('Conpago\Helpers\Contract\IResponse');
        $response->expects($this->once())->method('setHttpResponseCode')->with(500);

        $requestDataReader = $this->getMock('Conpago\Helpers\Contract\IRequestDataReader');
        $requestData = $this->getMock('Conpago\Helpers\Contract\IRequestData');
        $requestDataReader->expects($this->any())->method('getRequestData')->willReturn($requestData);

        $controller = $this->getMock('Conpago\Presentation\Contract\IController');
        $controller->expects($this->once())->method('execute')->willThrowException(new \Exception());

        $appConfig = $this->getMock('Conpago\Config\Contract\IAppConfig');

        $webApp = new WebApp($requestDataReader, $controller, $response, $logger, $appConfig);
        $webApp->run();
    }

    public function testExecuteController()
    {
        $logger = $this->getMock('Conpago\Logging\Contract\ILogger');

        $response = $this->getMock('Conpago\Helpers\Contract\IResponse');

        $requestDataReader = $this->getMock('Conpago\Helpers\Contract\IRequestDataReader');
        $requestData = $this->getMock('Conpago\Helpers\Contract\IRequestData');
        $requestDataReader->expects($this->any())->method('getRequestData')->willReturn($requestData);

        $controller = $this->getMock('Conpago\Presentation\Contract\IController');
        $controller->expects($this->once())->method('execute')->with($requestData);

        $appConfig = $this->getMock('Conpago\Config\Contract\IAppConfig');

        $webApp = new WebApp($requestDataReader, $controller, $response, $logger, $appConfig);
        $webApp->run();
    }
}
