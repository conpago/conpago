<?php
/**
 * Created by PhpStorm.
 * User: bgolek
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
use Conpago\File\Path;
use Conpago\Helpers\Contract\IAppPath;
use Conpago\Logging\Contract\ILogger;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class AppBuilderTest extends TestCase
    {
        /** @var IFileSystem | MockObject */
        private $fileSystem;

        /** @var IAppPath | MockObject */
        private $appPath;

        /** @var IContainerBuilder | MockObject */
        private $containerBuilder;

        private $xModulePath;

        const APP_PATH_FULL_NAME = 'Conpago\Helpers\Contract\IAppPath';
        const FILE_SYSTEM_FULL_NAME = 'Conpago\File\Contract\IFileSystem';

        /**
         * @var AppBuilder
         */
        private $appBuilder;

        public function testAppBuilderBuildAppWithoutModules()
        {
            $this->fileSystem->expects($this->any())
                ->method('glob')->with($this->xModulePath)->willReturn([]);

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

            $container->expects($this->once())->method('resolve')->with(IApp::class)->willReturn($app);

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
            $this->xModulePath = DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'xModule.php';
            $this->fileSystem = $this->createMock(self::FILE_SYSTEM_FULL_NAME);
            $this->appPath = $this->createMock(self::APP_PATH_FULL_NAME);
            $this->containerBuilder = $this->createMock(IContainerBuilder::class);
            $this->appBuilder = new AppBuilder($this->fileSystem, $this->appPath, $this->containerBuilder, 'x');

            $this->appPath->method('root')->willReturn(new Path('',''));
        }

        protected function setContainerBuilderMocks()
        {
            $instanceRegisterer = $this->createMock(IInstanceRegisterer::class);
            $instanceRegisterer->expects($this->exactly(2))
                ->method('asA')
                ->withConsecutive(
                    [$this->equalTo(self::FILE_SYSTEM_FULL_NAME)],
                    [$this->equalTo(self::APP_PATH_FULL_NAME)]
                );

            $this->containerBuilder
                ->expects($this->exactly(2))
                ->method('registerInstance')
                ->withConsecutive(
                    [$this->fileSystem],
                    [$this->appPath]
                )
                ->willReturn($instanceRegisterer);
        }

        protected function setModuleMocks()
        {
            $this->fileSystem->expects($this->any())
                ->method('glob')->with($this->xModulePath)->willReturn([$this->xModulePath]);

            $module = $this->createMock(IModule::class);
            $module->expects($this->once())->method('build')->with($this->containerBuilder);

            $this->fileSystem->expects($this->once())
                ->method('loadClass')
                ->with($this->xModulePath)
                ->willReturn($module);
        }
    }
