<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-19
 * Time: 23:46
 */

namespace Conpago\Core;

use Conpago\Config\Contract\IAppConfig;
use Conpago\Helpers\Contract\IRequestData;
use Conpago\Helpers\Contract\IRequestDataReader;
use Conpago\Helpers\Contract\IResponse;
use Conpago\Logging\Contract\ILogger;
use Conpago\Presentation\Contract\IController;
use PHPUnit\Framework\TestCase;

class WebAppTest extends TestCase
{
    public function testHttp500ErrorOnExceptionFromRequestDataReader()
    {
        $controller = $this->createMock(IController::class);
        $logger = $this->createMock(ILogger::class);
        $response = $this->createMock(IResponse::class);
        $response->expects($this->once())->method('setHttpResponseCode')->with(500);

        $requestDataReader = $this->createMock(IRequestDataReader::class);
        $requestDataReader->expects($this->any())->method('getRequestData')->willThrowException(new \Exception());

        $appConfig = $this->createMock(IAppConfig::class);

        $webApp = new WebApp($requestDataReader, $controller, $response, $logger, $appConfig);
        $webApp->run();
    }

    public function testHttp500ErrorOnExceptionFromController()
    {
        $logger = $this->createMock(ILogger::class);

        $response = $this->createMock(IResponse::class);
        $response->expects($this->once())->method('setHttpResponseCode')->with(500);

        $requestDataReader = $this->createMock(IRequestDataReader::class);
        $requestData = $this->createMock(IRequestData::class);
        $requestDataReader->expects($this->any())->method('getRequestData')->willReturn($requestData);

        $controller = $this->createMock(IController::class);
        $controller->expects($this->once())->method('execute')->willThrowException(new \Exception());

        $appConfig = $this->createMock(IAppConfig::class);

        $webApp = new WebApp($requestDataReader, $controller, $response, $logger, $appConfig);
        $webApp->run();
    }

    public function testExecuteController()
    {
        $logger = $this->createMock(ILogger::class);

        $response = $this->createMock(IResponse::class);

        $requestDataReader = $this->createMock(IRequestDataReader::class);
        $requestData = $this->createMock(IRequestData::class);
        $requestDataReader->expects($this->any())->method('getRequestData')->willReturn($requestData);

        $controller = $this->createMock(IController::class);
        $controller->expects($this->once())->method('execute')->with($requestData);

        $appConfig = $this->createMock(IAppConfig::class);

        $webApp = new WebApp($requestDataReader, $controller, $response, $logger, $appConfig);
        $webApp->run();
    }
}
