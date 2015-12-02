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
    use Conpago\File\FileSystem;
    use Conpago\Helpers\AppPath;

    class AppBuilderFactory
    {
        /**
         * @param string $contextName
         * @param string $appRootPath
         *
         * @return AppBuilder
         */
        public function createAppBuilder($contextName, $appRootPath)
        {
            list($fileSystem, $containerBuilder, $appPath) = $this->getAppBuilderDependencies($appRootPath);
            return new AppBuilder($fileSystem, $appPath, $containerBuilder, $contextName);
        }

        /**
         * @param IContainerBuilderPersister $containerBuilderPersister
         * @param string $contextName
         * @param string $appRootPath
         *
         * @return AppBuilder
         */
        public function createAppBuilderFromPersisted(IContainerBuilderPersister $persister, $contextName, $appRootPath)
        {
            $fileSystem = new FileSystem();
            $appPath = new AppPath($fileSystem, $appRootPath);
            $containerBuilder = $persister->loadContainerBuilder();

            return new AppBuilder($fileSystem, $appPath, $containerBuilder, $contextName);
        }

        /**
         * @param $appRootPath
         *
         * @return array
         */
        protected function getAppBuilderDependencies($appRootPath)
        {
            $fileSystem       = new FileSystem();
            $containerBuilder = new ContainerBuilder();
            $appPath          = new AppPath($fileSystem, $appRootPath);

            return array( $fileSystem, $containerBuilder, $appPath );
        }
    }
