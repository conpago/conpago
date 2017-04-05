<?php

namespace Conpago\Routing;


use Conpago\Core\ControllerFactory;
use Conpago\Helpers\Contract\IRequestData;
use Conpago\Helpers\Contract\IRequestDataReader;
use Conpago\Presentation\Contract\IController;
use Conpago\Routing\Config\Contract\IRoutingConfig;
use Conpago\Routing\Contract\MissingRoutingException;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class RouterTest extends TestCase
{
    const FAKE_CONTROLLER_NAME = 'ControllerName';
    const EMPTY_CONTROLLER_NAME = '';

    /** @var Router */
    private $router;

    /** @var IRoutingConfig | MockObject */
    private $routingConfigMock;

    /** @var IRequestDataReader | MockObject */
    private $requestDataReaderMock;

    /** @var ControllerFactory | MockObject */
    private $controllerFactoryMock;

    /** @var IRequestData | MockObject */
    private $requestDataMock;

    public function testGetController_ShouldCallRoutingConfigWithSlash_IfPathIsNotGiven()
    {
        $this->routingConfigMock
            ->expects($this->once())
            ->method('getRoutings')
            ->with($this->anything(), '/')
            ->willReturn(self::FAKE_CONTROLLER_NAME);

        $this->requestDataMock->method('getUrlElements')->willReturn([]);
        $this->requestDataMock->method('getRequestMethod')->willReturn('GET');
        $this->router->getController();
    }

    public function testGetController_ShouldThrowMissingRoutingException_IfConfigReturnEmptyControllerName()
    {
        $this->routingConfigMock
            ->expects($this->once())
            ->method('getRoutings')
            ->with($this->anything(), $this->anything())
            ->willReturn(self::EMPTY_CONTROLLER_NAME);

        $this->requestDataMock->method('getUrlElements')->willReturn([]);
        $this->requestDataMock->method('getRequestMethod')->willReturn('');

        $this->expectException(MissingRoutingException::class);
        $this->router->getController();
    }

    public function testGetController_ShouldThrowMissingRoutingException_IfConfigReturnNull()
    {
        $this->routingConfigMock
            ->expects($this->once())
            ->method('getRoutings')
            ->with($this->anything(), $this->anything())
            ->willReturn(null);

        $this->requestDataMock->method('getUrlElements')->willReturn([]);
        $this->requestDataMock->method('getRequestMethod')->willReturn('');

        $this->expectException(MissingRoutingException::class);
        $this->router->getController();
    }

    public function testGetController_ShouldCallRoutingConfigWithPathPrefixedAndConnectedBySlash_IfPathIsGiven()
    {
        $this->routingConfigMock
            ->expects($this->once())
            ->method('getRoutings')
            ->with($this->anything(), '/aaa/bbb/ccc')
            ->willReturn(self::FAKE_CONTROLLER_NAME);

        $this->requestDataMock->method('getUrlElements')->willReturn(['aaa', 'bbb', 'ccc']);
        $this->requestDataMock->method('getRequestMethod')->willReturn('GET');
        $this->router->getController();
    }

    /**
     * @dataProvider requestMethods
     */
    public function testGetController_ShouldCallRoutingConfigWithGivenRequestData($requestMethod)
    {
        $this->routingConfigMock
            ->expects($this->once())
            ->method('getRoutings')
            ->with($requestMethod, $this->anything())
            ->willReturn(self::FAKE_CONTROLLER_NAME);

        $this->requestDataMock->method('getUrlElements')->willReturn([]);
        $this->requestDataMock->method('getRequestMethod')->willReturn($requestMethod);
        $this->router->getController();
    }

    public function requestMethods()
    {
        return [
            ['GET'],
            ['POST']
        ];
    }

    /**
     * @dataProvider controllerNames
     */
    public function testGetController_ShouldCallControllerFactoryWithControllerNameReturnedByConfig($controllerName)
    {
        $this->routingConfigMock
            ->method('getRoutings')
            ->with($this->anything(), $this->anything())
            ->willReturn($controllerName);

        $this->controllerFactoryMock
            ->expects($this->once())
            ->method('createController')
            ->with($controllerName);

        $this->requestDataMock->method('getUrlElements')->willReturn([]);
        $this->requestDataMock->method('getRequestMethod')->willReturn('GET');

        $this->router->getController();
    }

    public function controllerNames()
    {
        return [
            ['C1'],
            ['X3']
        ];
    }

    public function testGetController_ShouldReturnControllerCreatedByControllerFactory()
    {
        $this->routingConfigMock
            ->method('getRoutings')
            ->with($this->anything(), $this->anything())
            ->willReturn('x');

        $controllerMock = $this->createMock(IController::class);

        $this->controllerFactoryMock
            ->expects($this->once())
            ->method('createController')
            ->willReturn($controllerMock);

        $this->requestDataMock->method('getUrlElements')->willReturn([]);
        $this->requestDataMock->method('getRequestMethod')->willReturn('GET');

        $this->assertSame($controllerMock, $this->router->getController());
    }

    public function setUp()
    {
        $this->routingConfigMock = $this->createMock(IRoutingConfig::class);
        $this->requestDataReaderMock = $this->createMock(IRequestDataReader::class);
        $this->requestDataMock = $this->createMock(IRequestData::class);
        $this->controllerFactoryMock = $this->createMock(ControllerFactory::class);

        $this->requestDataReaderMock
            ->method('getRequestData')
            ->willReturn($this->requestDataMock);

        $this->router = new Router(
            $this->routingConfigMock,
            $this->requestDataReaderMock,
            $this->controllerFactoryMock
        );
    }
}
