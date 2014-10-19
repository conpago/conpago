<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago;

	use Saigon\Conpago\DI\IContainer;
	use Saigon\Conpago\DI\IContainerBuilder;
	use Saigon\Conpago\DI\IContainerBuilderPersister;
	use Saigon\Conpago\DI\IPersistableContainerBuilder;
	use Saigon\Conpago\Helpers\Contract\IAppPath;
	use Saigon\Conpago\Helpers\Contract\IFileSystem;

	class AppBuilder
	{
		/**
		 * @var IContainerBuilderPersister
		 */
		private $persister;

		/**
		 * @var IAppPath
		 */
		protected $appRoot;

		/**
		 * @var IPersistableContainerBuilder
		 */
		protected $builder;

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
		 * @param IAppPath $appRoot
		 * @param IContainerBuilder $containerBuilder
		 * @param IContainerBuilderPersister $persister
		 * @param string $contextName
		 */
		public function __construct(
			IFileSystem $fileSystem,
			IAppPath $appRoot,
			IContainerBuilder $containerBuilder,
			IContainerBuilderPersister $persister,
			$contextName)
		{
			$this->appRoot = $appRoot;
			$this->contextName = $contextName;
			$this->fileSystem = $fileSystem;
			$this->containerBuilder = $containerBuilder;
			$this->persister = $persister;
		}

		/**
		 * @return IContainer
		 */
		public function getContainer()
		{
			if (!$this->container)
			{
				$this->container = $this->builder->build();
			}

			return $this->container;
		}

		protected function getBuilder()
		{
			return $this->containerBuilder;
		}

		private function getFileName($filePath)
		{
			$filePathArray = explode(DIRECTORY_SEPARATOR, $filePath);

			return array_pop($filePathArray);
		}

		private function getClassName($filePath)
		{
			$fileName = $this->getFileName($filePath);

			return substr($fileName, 0, strlen($fileName) - strlen('.php'));
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
				$this->fileSystem->requireOnce($filePath);

				$className = $this->getClassName($filePath);

				/** @var \Saigon\Conpago\IModule $class */
				$class = new $className();
				$class->build($this->builder);
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
				$additionalModule->build($this->builder);
		}

		protected function initializeContainer()
		{
			$this->builder = $this->getBuilder();
		}

		public function buildApp()
		{
			$this->initializeContainer();
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
				->builder
				->registerInstance($this->fileSystem)
				->asA('Saigon\Conpago\Helpers\IFileSystem');
		}

		private function registerAppPath()
		{
			$this
				->builder
				->registerInstance($this->appRoot)
				->asA('Saigon\Conpago\IAppPath');
		}

		public function persistApp()
		{
			$this->persister->saveContainerBuilder($this->builder);
		}

		public function readPersistedApp()
		{
			$this->builder = $this->persister->loadContainerBuilder();
		}
	}
