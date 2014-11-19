<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago;

	use Saigon\Conpago\DI\IContainer;
	use Saigon\Conpago\DI\IModule;
	use Saigon\Conpago\DI\IContainerBuilder;
	use Saigon\Conpago\Helpers\Contract\IAppPath;
	use Saigon\Conpago\Helpers\Contract\IFileSystem;

	class AppBuilder
	{
		/**
		 * @var IAppPath
		 */
		protected $appPath;

		/**
		 * @var IContainer
		 */
		protected $container;

		/**
		 * @var string
		 */
		private $contextName;

		/**
		 * @var IFileSystem
		 */
		private $fileSystem;
		/**
		 * @var IContainerBuilder
		 */
		private $containerBuilder;

		/**
		 * @param IFileSystem $fileSystem
		 * @param IAppPath $appPath
		 * @param IContainerBuilder $containerBuilder
		 * @param string $contextName
		 */
		public function __construct(
			IFileSystem $fileSystem,
			IAppPath $appPath,
			IContainerBuilder $containerBuilder,
			$contextName)
		{
			$this->appPath = $appPath;
			$this->contextName = $contextName;
			$this->fileSystem = $fileSystem;
			$this->containerBuilder = $containerBuilder;
		}

		/**
		 * @return IContainer
		 */
		public function getContainer()
		{
			if (!$this->container)
				$this->container = $this->containerBuilder->build();

			return $this->container;
		}

		protected function loadModules()
		{
			$moduleMask = implode(DIRECTORY_SEPARATOR,
				array(
					$this->appPath->root(),
					"src",
					$this->contextName . "Module.php"
				));

			foreach ($this->fileSystem->glob($moduleMask) as $filePath)
			{
				/** @var IModule $class */
				$class = $this->fileSystem->loadClass($filePath);
				$class->build($this->containerBuilder);
			}
		}

		/** @var IModule[] */
		protected $additionalModules = array();

		public function registerAdditionalModule(IModule $module)
		{
			$this->additionalModules[] = $module;
		}

		protected function loadAdditionalModules()
		{
			foreach ($this->additionalModules as $additionalModule)
				$additionalModule->build($this->containerBuilder);
		}

		public function buildApp()
		{
			$this->registerFileSystem();
			$this->registerAppPath();
			$this->loadModules();
			$this->loadAdditionalModules();
		}

		/**
		 * @return \Saigon\Conpago\IApp;
		 */
		public function getApp()
		{
			return $this->getContainer()->resolve('Saigon\Conpago\IApp');
		}

		private function registerFileSystem()
		{
			$this
				->containerBuilder
				->registerInstance($this->fileSystem)
				->asA('Saigon\Conpago\Helpers\Contract\IFileSystem');
		}

		private function registerAppPath()
		{
			$this
				->containerBuilder
				->registerInstance($this->appPath)
				->asA('Saigon\Conpago\Helpers\Contract\IAppPath');
		}
	}
