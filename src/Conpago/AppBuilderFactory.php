<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-20
	 * Time: 00:10
	 */

	namespace Conpago;

	use Conpago\DI\ContainerBuilder;
	use Conpago\DI\IContainerBuilderPersister;
	use Conpago\Helpers\AppPath;
	use Conpago\Helpers\FileSystem;

	class AppBuilderFactory
	{
		/**
		 * @param string $contextName
		 * @param string $appRootPath
		 *
		 * @return AppBuilder
		 */
		function createAppBuilder($contextName, $appRootPath)
		{
			$fileSystem = new FileSystem();
			$containerBuilder = new ContainerBuilder();
			$appPath = new AppPath($fileSystem, $appRootPath);

			return new AppBuilder($fileSystem, $appPath, $containerBuilder, $contextName);
		}

		/**
		 * @param IContainerBuilderPersister $containerBuilderPersister
		 * @param string $contextName
		 * @param string $appRootPath
		 *
		 * @return AppBuilder
		 */
		function createAppBuilderFromPersisted(IContainerBuilderPersister $persister, $contextName, $appRootPath)
		{
			$fileSystem = new FileSystem();
			$appPath = new AppPath($fileSystem, $appRootPath);
			$containerBuilder = $persister->loadContainerBuilder();

			return new AppBuilder($fileSystem, $appPath, $containerBuilder, $contextName);
		}
	}
