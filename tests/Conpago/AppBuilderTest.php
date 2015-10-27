<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-20
	 * Time: 08:11
	 */

	namespace Conpago;


	use Conpago\DI\IContainerBuilder;

	class AppBuilderTest extends \PHPUnit_Framework_TestCase
	{
		private $fileSystem;

		private $appPath;

		private $containerBuilder;
		private $xModulePath;
		const APP_PATH_FULL_NAME = 'Conpago\Helpers\Contract\IAppPath';
		const FILE_SYSTEM_FULL_NAME = 'Conpago\File\Contract\IFileSystem';

		/**
		 * @var AppBuilder
		 */
		private $appBuilder;

		function testAppBuilderBuildAppWithoutModules()
		{
			$this->fileSystem->expects($this->any())
				->method('glob')->with($this->xModulePath)->willReturn(array());

			$this->setContainerBuilderMocks();

			$this->appBuilder->buildApp();
		}

		function testAppBuilderBuildAppWithModule()
		{
			$this->setContainerBuilderMocks();
			$this->setModuleMocks();

			$this->appBuilder->buildApp();
		}

		function testAppBuilderBuildAppWithAdditionalModules()
		{
			$this->setContainerBuilderMocks();
			$this->setModuleMocks();

			$additionalModule = $this->getMock('Conpago\DI\IModule');
			$additionalModule->expects($this->once())->method('build')->with($this->containerBuilder);

			$this->appBuilder->registerAdditionalModule($additionalModule);
			$this->appBuilder->buildApp();
		}

		function testAppBuilderBuildGetApp()
		{
			$app = $this->getMock('Conpago\Contract\IApp');
			$container = $this->getMock('Conpago\DI\IContainer');
			$this->containerBuilder->expects($this->once())->method('build')->willReturn($container);

			$container->expects($this->once())->method('resolve')->with('Conpago\Contract\IApp')->willReturn($app);

			$this->assertSame($app, $this->appBuilder->getApp());
		}

		function testAppBuilderBuildGetLogger()
		{
			$logger = $this->getMock('Conpago\Logging\Contract\ILogger');
			$container = $this->getMock('Conpago\DI\IContainer');
			$this->containerBuilder->expects($this->once())->method('build')->willReturn($container);

			$container->expects($this->once())->method('resolve')->with('Conpago\Logging\Contract\ILogger')->willReturn($logger);

			$this->assertSame($logger, $this->appBuilder->getLogger());
		}

		protected function setUp()
		{
			$this->xModulePath = DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'xModule.php';
			$this->fileSystem = $this->getMock(self::FILE_SYSTEM_FULL_NAME);
			$this->appPath = $this->getMock(self::APP_PATH_FULL_NAME);
			$this->containerBuilder = $this->getMock('Conpago\DI\IContainerBuilder');
			$this->appBuilder = new AppBuilder($this->fileSystem, $this->appPath, $this->containerBuilder, 'x');
		}

		protected function setContainerBuilderMocks()
		{
			$instanceRegisterer = $this->getMock('Conpago\DI\IInstanceRegisterer');
			$instanceRegisterer->expects($this->exactly(2))
				->method('asA')
				->withConsecutive(
					array($this->equalTo(self::FILE_SYSTEM_FULL_NAME)),
					array($this->equalTo(self::APP_PATH_FULL_NAME))
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
			$this->fileSystem->expects($this->any())
				->method('glob')->with($this->xModulePath)->willReturn(array($this->xModulePath));

			$module = $this->getMock('Conpago\DI\IModule');
			$module->expects($this->once())->method('build')->with($this->containerBuilder);

			$this->fileSystem->expects($this->once())
				->method('loadClass')
				->with($this->xModulePath)
				->willReturn($module);
		}
	}
