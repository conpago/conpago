<?php


namespace Conpago\Core;

use Conpago\DI\IFactory;
use Conpago\Exceptions\ControllerNotFoundException;
use Conpago\Presentation\Contract\IController;
use PHPUnit\Framework\TestCase;

class ControllerFactoryTest extends TestCase
{

    /** @var ControllerFactory */
    private $controllerFactory;

    public function testCreateController_ShouldThrowMissingControllerException_IfFactoryIsNotRegistered()
    {
        $this->controllerFactory = new ControllerFactory([]);
        $this->expectException(ControllerNotFoundException::class);

        $this->controllerFactory->createController("HelloController");
    }

    public function testCreateController_ShouldReturnController_IfFactoryIsRegistered()
    {
        $controllerMock = $this->createMock(IController::class);
        $factoryMock = $this->createMock(IFactory::class);

        $factoryMock->method('createInstance')->willReturn($controllerMock);

        $this->controllerFactory = new ControllerFactory(
            ['HelloController' => $factoryMock]
        );

        $this->assertSame($controllerMock, $this->controllerFactory->createController("HelloController"));
    }
}