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
use Conpago\Time\Contract\ITimeZone;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class WebAppTest extends TestCase
{
    const ANY_TIMEZONE = 'some/timezone';
    const EMPTY_VALUE = '';

    /** @var WebApp */
    private $webApp;

    /** @var  IAppConfig | MockObject */
    private $appConfigMock;

    /** @var  IResponse | MockObject */
    private $responseMock;

    /** @var  IRequestDataReader | MockObject */
    private $requestDataReaderMock;

    /** @var  ILogger | MockObject */
    private $loggerMock;

    /** @var  IController | MockObject */
    private $controllerMock;

    /** @var  ITimeZone | MockObject */
    private $timeZoneMock;

    public function testRunShouldSetHttp500ErrorIfRequestDataReaderThrowsException()
    {
        $this->requestDataReaderMock->method('getRequestData')->willThrowException(new \Exception());
        $this->responseMock->expects($this->once())->method('setHttpResponseCode')->with(500);

        $this->webApp->run();
    }

    public function testRunShouldSetHttp500ErrorIfControllerThrowsException()
    {
        $this->responseMock->expects($this->once())->method('setHttpResponseCode')->with(500);

        $requestData = $this->createMock(IRequestData::class);
        $this->requestDataReaderMock->method('getRequestData')->willReturn($requestData);

        $this->controllerMock->expects($this->once())->method('execute')->willThrowException(new \Exception());

        $this->webApp->run();
    }

    public function testRunShouldRunControllerWithRequestedData()
    {
        $requestData = $this->createMock(IRequestData::class);
        $this->requestDataReaderMock->method('getRequestData')->willReturn($requestData);
        $this->controllerMock->expects($this->once())->method('execute')->with($requestData);

        $this->webApp->run();
    }

    public function testRunShouldSetTimeZoneIfAppConfigReturnsNotEmptyValue()
    {
        $requestData = $this->createMock(IRequestData::class);
        $this->requestDataReaderMock->method('getRequestData')->willReturn($requestData);
        $this->controllerMock->expects($this->once())->method('execute')->with($requestData);

        $this->appConfigMock->method('getTimeZone')->willReturn(self::ANY_TIMEZONE);

        $this->timeZoneMock
            ->expects($this->once())
            ->method('setDefaultTimeZone')
            ->with(self::ANY_TIMEZONE);

        $this->webApp->run();
    }

    public function testRunShouldNotSetTimeZoneIfAppConfigReturnsEmptyValue()
    {
        $requestData = $this->createMock(IRequestData::class);
        $this->requestDataReaderMock->method('getRequestData')->willReturn($requestData);
        $this->controllerMock->expects($this->once())->method('execute')->with($requestData);

        $this->appConfigMock->method('getTimeZone')->willReturn(self::EMPTY_VALUE);

        $this->timeZoneMock
            ->expects($this->never())
            ->method('setDefaultTimeZone');

        $this->webApp->run();
    }

    public function testRunShouldNotSetTimeZoneIfAppConfigReturnsNull()
    {
        $requestData = $this->createMock(IRequestData::class);
        $this->requestDataReaderMock->method('getRequestData')->willReturn($requestData);
        $this->controllerMock->expects($this->once())->method('execute')->with($requestData);

        $this->appConfigMock->method('getTimeZone')->willReturn(null);

        $this->timeZoneMock
            ->expects($this->never())
            ->method('setDefaultTimeZone');

        $this->webApp->run();
    }

    public function setUp()
    {
        $this->controllerMock = $this->createMock(IController::class);
        $this->loggerMock = $this->createMock(ILogger::class);
        $this->requestDataReaderMock = $this->createMock(IRequestDataReader::class);
        $this->responseMock = $this->createMock(IResponse::class);
        $this->appConfigMock = $this->createMock(IAppConfig::class);
        $this->timeZoneMock = $this->createMock(ITimeZone::class);

        $this->webApp = new WebApp(
            $this->requestDataReaderMock,
            $this->controllerMock,
            $this->responseMock,
            $this->loggerMock,
            $this->timeZoneMock,
            $this->appConfigMock
        );
    }
}
