<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-20
	 * Time: 08:11
	 */

	namespace Saigon\Conpago;


	use Saigon\Conpago\DI\IContainerBuilder;

	class AppBuilderTest extends \PHPUnit_Framework_TestCase
	{
		private $fileSystem;

		private $appPath;

		private $containerBuilder;

		/**
		 * @var AppBuilder
		 */
		private $appBuilder;

		function testAppBuilderGetContainer()
		{
			$container = $this->getMock('Saigon\Conpago\DI\IContainer');
			$this->containerBuilder->expects($this->once())->method('build')->willReturn($container);

			$this->assertSame($this->appBuilder->getContainer(), $this->appBuilder->getContainer());
		}

		function testAppBuilderBuildAppWithoutModules()
		{
			$this->fileSystem->expects($this->any())
				->method('glob')->with('\src\xModule.php')->willReturn(array());

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

			$additionalModule = $this->getMock('Saigon\Conpago\IModule');
			$additionalModule->expects($this->once())->method('build')->with($this->containerBuilder);

			$this->appBuilder->registerAdditionalModule($additionalModule);
			$this->appBuilder->buildApp();
		}

		function testAppBuilderBuildGetApp()
		{
			$app = $this->getMock('Saigon\Conpago\IApp');
			$container = $this->getMock('Saigon\Conpago\DI\IContainer');
			$this->containerBuilder->expects($this->once())->method('build')->willReturn($container);

			$container->expects($this->once())->method('resolve')->with('Saigon\Conpago\IApp')->willReturn($app);

			$this->assertSame($app, $this->appBuilder->getApp());
		}

		protected function setUp()
		{
			$this->fileSystem = $this->getMock('Saigon\Conpago\Helpers\Contract\IFileSystem');
			$this->appPath = $this->getMock('Saigon\Conpago\Helpers\Contract\IAppPath');
			$this->containerBuilder = $this->getMock('Saigon\Conpago\DI\IContainerBuilder');
			$this->appBuilder = new AppBuilder($this->fileSystem, $this->appPath, $this->containerBuilder, 'x');
		}

		protected function setContainerBuilderMocks()
		{
			$instanceRegisterer = $this->getMock('Saigon\Conpago\DI\IInstanceRegisterer');
			$instanceRegisterer->expects($this->exactly(2))
				->method('asA')
				->withConsecutive(
					array($this->equalTo('Saigon\Conpago\Helpers\IFileSystem')),
					array($this->equalTo('Saigon\Conpago\IAppPath'))
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
				->method('glob')->with('\src\xModule.php')->willReturn(array('\src\xModule.php'));

			$module = $this->getMock('Saigon\Conpago\IModule');
			$module->expects($this->once())->method('build')->with($this->containerBuilder);

			$this->fileSystem->expects($this->once())
				->method('loadClass')
				->with('\src\xModule.php')
				->willReturn($module);
		}
	}
 