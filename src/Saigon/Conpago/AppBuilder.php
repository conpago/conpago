<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago;

	use Saigon\Conpago\Core\BuilderStorage;
	use Saigon\Conpago\DI\ContainerBuilder;
	use Saigon\Conpago\DI\ContainerBuilderPersister;
	use Saigon\Conpago\DI\IContainer;
	use Saigon\Conpago\DI\IPersistableContainerBuilder;

	class AppBuilder
	{

		/**
		 * @var string
		 */
		protected $appRootPath;

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
		 * @param string $contextName
		 * @param string $appRootPath
		 */
		public function __construct($contextName, $appRootPath)
		{
			$this->appRootPath = $appRootPath;
			$this->contextName = $contextName;
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
			return new ContainerBuilder();
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
					$this->appRootPath,
					"src",
					$this->contextName . "Module.php"
				));

			foreach (glob($moduleMask) as $filePath)
			{
				require_once $filePath;

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

		private function registerAppPath()
		{
			$this
				->builder
				->registerType('Saigon\Conpago\Helpers\AppPath')
				->withParams($this->appRootPath)
				->asA('Saigon\Conpago\IAppPath');
		}

		public function persistApp()
		{
			$storage = new BuilderStorage($this->appRootPath, $this->contextName);
			$persister = new ContainerBuilderPersister($storage);
			$persister->saveContainerBuilder($this->builder);
		}

		public function readPersistedApp()
		{
			$storage = new BuilderStorage($this->appRootPath, $this->contextName);
			$persister = new ContainerBuilderPersister($storage);
			$this->builder = $persister->loadContainerBuilder();
		}
	}
