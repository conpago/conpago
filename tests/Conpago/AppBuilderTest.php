<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-20
 * Time: 08:11
 */

namespace Conpago;

use Conpago\Contract\IApp;
use Conpago\DI\IContainer;
use Conpago\DI\IContainerBuilder;
use Conpago\DI\IInstanceRegisterer;
use Conpago\DI\IModule;
use Conpago\File\Contract\IFileSystem;
use Conpago\File\Contract\IPath;
use Conpago\Helpers\Contract\IAppPath;
use Conpago\Logging\Contract\ILogger;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class AppBuilderTest extends TestCase
{
    /** @var  IPath | MockObject */
    protected $pathMock;

    /** @var IFileSystem | MockObject */
    private $fileSystem;

    /** @var IAppPath | MockObject */
    private $appPath;

    /** @var IContainerBuilder | MockObject */
    private $containerBuilder;

    /** @var IPath */
    private $xModulePath;

    /**
     * @var AppBuilder
     */
    private $appBuilder;

    public function testAppBuilderBuildAppWithoutModules()
    {
        $this->fileSystem
            ->method('glob')
            ->with($this->xModulePath)
            ->willReturn([]);

        $this->setContainerBuilderMocks();

        $this->appBuilder->buildApp();
    }

    public function testAppBuilderBuildAppWithModule()
    {
        $this->setContainerBuilderMocks();
        $this->setModuleMocks();

        $this->appBuilder->buildApp();
    }

    public function testAppBuilderBuildGetApp()
    {
        $app = $this->createMock(IApp::class);
        $container = $this->createMock(IContainer::class);
        $this->containerBuilder->expects($this->once())->method('build')->willReturn($container);

        $container->expects($this->once())->method('resolve')->with('Conpago\Contract\IApp')->willReturn($app);

        $this->assertSame($app, $this->appBuilder->getApp());
    }

    public function testAppBuilderBuildGetLogger()
    {
        $logger = $this->createMock(ILogger::class);
        $container = $this->createMock(IContainer::class);
        $this->containerBuilder->expects($this->once())->method('build')->willReturn($container);

        $container->expects($this->once())->method('resolve')->with(ILogger::class)->willReturn($logger);

        $this->assertSame($logger, $this->appBuilder->getLogger());
    }

    protected function setUp()
    {
//        $this->xModulePath = $this->createMock(IPath::class);
//        $this->xModulePath
//            ->method('get')
//            ->willReturn(DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'xModule.php');
        $this->xModulePath = DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'xModule.php';

        $this->fileSystem = $this->createMock(IFileSystem::class);
        $this->appPath = $this->createMock(IAppPath::class);

        $this->pathMock = $this->createMock(IPath::class);
        $this->pathMock->method('get')->willReturn('');

        $this->appPath->method('root')->willReturn($this->pathMock);

        $this->containerBuilder = $this->createMock(IContainerBuilder::class);

        $this->appBuilder = new AppBuilder(
            $this->fileSystem,
            $this->appPath,
            $this->containerBuilder,
            'x'
        );
    }

    protected function setContainerBuilderMocks()
    {
        $instanceRegisterer = $this->createMock(IInstanceRegisterer::class);
        $instanceRegisterer->expects($this->exactly(2))
            ->method('asA')
            ->withConsecutive(
                array($this->equalTo(IFileSystem::class)),
                array($this->equalTo(IAppPath::class))
            );

        $this->containerBuilder
            ->expects($this->exactly(2))
            ->method('registerInstance')
            ->withConsecutive(
                array($this->fileSystem),
                array($this->appPath)
            )
            ->willReturn($instanceRegisterer);
    }

    protected function setModuleMocks()
    {
        $this->fileSystem
            ->method('glob')
            ->with($this->xModulePath)
            ->willReturn([$this->xModulePath]);

        $module = $this->createMock(IModule::class);
        $module->expects($this->once())->method('build')->with($this->containerBuilder);

        $this->fileSystem->expects($this->once())
            ->method('loadClass')
            ->with($this->xModulePath)
            ->willReturn($module);
    }
}
