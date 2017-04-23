<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-19
 * Time: 23:17
 */

namespace Conpago\Core;

use Conpago\Config\Contract\IAppConfig;
use Conpago\DI\IFactory;
use Conpago\Exceptions\ControllerNotFoundException;
use Conpago\Helpers\Contract\IRequestDataReader;
use Conpago\Presentation\Contract\IController;
use PHPUnit\Framework\TestCase;

class ControllerResolverTest extends TestCase
{
    public $requestData;
    private $requestDataReader;

    private $appConfig;

    private $controllerFactories = array();

    public function setUp()
    {
        $this->requestDataReader = $this->createMock(IRequestDataReader::class);
        $this->appConfig = $this->createMock(IAppConfig::class);
        $this->requestData = $this->createMock(RequestData::class);

        $this->requestDataReader->expects($this->any())
                ->method('getRequestData')->willReturn($this->requestData);
    }

    public function testNotExistingController()
    {
        $this->expectException(ControllerNotFoundException::class);
        $this->expectExceptionMessage('Controller \'\' not found.');
        $controllerResolver = new ControllerResolver(
                $this->requestDataReader,
                $this->appConfig,
                $this->controllerFactories);

        $controllerResolver->getController();
    }

    public function testNonDefaultInteractorController()
    {
        $this->appConfig->expects($this->any())
                ->method('getDefaultInteractor')
                ->willReturn('default');

        $this->requestData->expects($this->once())->method('getParameters')->willReturn(array('interactor' => 'nonDefault'));

        $controller = $this->createMock(IController::class);

        $commandFactory = $this->createMock(IFactory::class);
        $commandFactory->expects($this->once())->method('createInstance')->willReturn($controller);

        $this->controllerFactories['nonDefaultController'] = $commandFactory;

        $controllerResolver = new ControllerResolver(
                $this->requestDataReader,
                $this->appConfig,
                $this->controllerFactories);

        $this->assertEquals($controller, $controllerResolver->getController());
    }

    public function testDefaultInteractorController()
    {
        $this->appConfig->expects($this->any())
                ->method('getDefaultInteractor')
                ->willReturn('default');

        $controller = $this->createMock(IController::class);

        $commandFactory = $this->createMock(IFactory::class);
        $commandFactory->expects($this->once())->method('createInstance')->willReturn($controller);

        $this->controllerFactories['defaultController'] = $commandFactory;

        $controllerResolver = new ControllerResolver(
                $this->requestDataReader,
                $this->appConfig,
                $this->controllerFactories);

        $this->assertEquals($controller, $controllerResolver->getController());
    }
}
