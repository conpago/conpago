<?php
    /**
     * Created by PhpStorm.
     * User: Bartosz Gołek
     * Date: 09.11.13
     * Time: 15:30
     */

    namespace Conpago;

    use Conpago\DI\IContainer;
    use Conpago\DI\IModule;
    use Conpago\DI\IContainerBuilder;
    use Conpago\File\Contract\IFileSystem;
    use Conpago\Helpers\Contract\IAppPath;
    use Conpago\Logging\Contract\ILogger;

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

        protected function loadModules()
        {
            $moduleMask = implode(DIRECTORY_SEPARATOR,
                array(
                    $this->appPath->root(),
                    "src",
                    $this->contextName . "Module.php"
                ));

            foreach ($this->fileSystem->glob($moduleMask) as $filePath) {
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
            foreach ($this->additionalModules as $additionalModule) {
                $additionalModule->build($this->containerBuilder);
            }
        }

        /**
         * @return IContainer
         */
        protected function getContainer()
        {
            if (!$this->container) {
                $this->container = $this->containerBuilder->build();
            }

            return $this->container;
        }

        public function buildApp()
        {
            $this->registerFileSystem();
            $this->registerAppPath();
            $this->loadModules();
            $this->loadAdditionalModules();
        }

        /**
         * @return ILogger;
         */
        public function getLogger()
        {
            return $this->getContainer()->resolve('Conpago\Logging\Contract\ILogger');
        }

        /**
         * @return \Conpago\Contract\IApp;
         */
        public function getApp()
        {
            return $this->getContainer()->resolve('Conpago\Contract\IApp');
        }

        private function registerFileSystem()
        {
            $this
                ->containerBuilder
                ->registerInstance($this->fileSystem)
                ->asA('Conpago\File\Contract\IFileSystem');
        }

        private function registerAppPath()
        {
            $this
                ->containerBuilder
                ->registerInstance($this->appPath)
                ->asA('Conpago\Helpers\Contract\IAppPath');
        }
    }
