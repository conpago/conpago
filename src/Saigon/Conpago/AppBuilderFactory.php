<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-20
	 * Time: 00:10
	 */

	namespace Saigon\Conpago;

	use Saigon\Conpago\Core\BuilderStorage;
	use Saigon\Conpago\DI\ContainerBuilder;
	use Saigon\Conpago\DI\ContainerBuilderPersister;
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
			$storage = new BuilderStorage($fileSystem, $appPath, $contextName);

			return new AppBuilder($fileSystem, $appPath, $containerBuilder, $contextName);
		}

	/**
	 * @param string $contextName
	 * @param string $appRootPath
	 *
	 * @return AppBuilder
	 */
		function createAppBuilderFromPersisted($contextName, $appRootPath)
		{
			$fileSystem = new FileSystem();
			$appPath = new AppPath($fileSystem, $appRootPath);
			$storage = new BuilderStorage($fileSystem, $appPath, $contextName);
			$containerBuilderPersister = new ContainerBuilderPersister($storage);
			$containerBuilder = $containerBuilderPersister->loadContainerBuilder();

			return new AppBuilder($fileSystem, $appPath, $containerBuilder, $contextName);
		}
	}