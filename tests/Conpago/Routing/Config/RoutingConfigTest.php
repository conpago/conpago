<?php


namespace Conpago\Routing\Config;

use Conpago\Config\Contract\IConfig;
use Conpago\Routing\Config\Contract\IRoutingConfig;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;


class RoutingConfigTest extends TestCase
{
    /** @var IRoutingConfig | MockObject */
    private $routingConfig;

    /** @var IConfig|\PHPUnit_Framework_MockObject_MockObject */
    private $configMock;

    public function testGetRoutings_ShouldGetValueFromConfig()
    {
        $this->configMock->expects($this->once())->method('getValue')->with('routing.GET');

        $this->routingConfig->getRoutings('GET', '/');
    }

    public function testGetRoutings_ShouldReturnConfigsReturnedByConfigGetValue()
    {
        $this->configMock->method('getValue')->willReturn([
            '/' => 'MainController'
        ]);

        $routings = $this->routingConfig->getRoutings('GET', '/');

        $this->assertSame([
            '/' => 'MainController'
        ], $routings);
    }

    public function testGetRoutings_ShouldFilterConfigsReturnedByConfigGetValueByPath()
    {
        $this->configMock->method('getValue')->willReturn([
            '/' => 'MainController',
            '/a' => 'AController',
            '/c' => 'CController',
        ]);

        $routings = $this->routingConfig->getRoutings('GET', '/a');

        $this->assertSame([
            '/a' => 'AController'
        ], $routings);
    }

    public function testGetRoutings_ShouldReturnConfigsWithParams()
    {
        $this->configMock->method('getValue')->willReturn([
            '/' => 'MainController',
            '/als/c' => 'MainController',
            '/{xxx}/c' => 'AController',
            '/c' => 'CController',
        ]);

        $routings = $this->routingConfig->getRoutings('GET', '/als/c');

        $this->assertSame([
            '/als/c' => 'MainController',
            '/{xxx}/c' => 'AController',
        ], $routings);
    }

    public function setUp()
    {
        $this->configMock = $this->createMock(IConfig::class);
        $this->routingConfig = new RoutingConfig($this->configMock);
    }
}