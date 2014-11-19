<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-20
	 * Time: 00:10
	 */

	namespace Saigon\Conpago;

	use Saigon\Conpago\DI\ContainerBuilder;
	use Saigon\Conpago\DI\IContainerBuilderPersister;
	use Saigon\Conpago\Helpers\AppPath;
	use Saigon\Conpago\Helpers\FileSystem;

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