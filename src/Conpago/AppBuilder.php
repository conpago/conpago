<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 09.11.13
 * Time: 15:30
 *
 * @package    Conpago
 * @subpackage Core
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago;

use Conpago\Contract\IApp;
use Conpago\DI\IContainer;
use Conpago\DI\IModule;
use Conpago\DI\IContainerBuilder;
use Conpago\File\Contract\IFileSystem;
use Conpago\Helpers\Contract\IAppPath;
use Conpago\Logging\Contract\ILogger;

/**
 * Builds application using container Modules.
 */
class AppBuilder
{

    /**
     * Provider for application base paths.
     *
     * @var IAppPath
     */
    protected $appPath;

    /**
     * Provider for application DI container.
     *
     * @var IContainer
     */
    protected $container;

    /**
     * Name of building context.
     *
     * @var string
     */
    private $contextName;

    /**
     * Provider for file system access.
     *
     * @var IFileSystem
     */
    private $fileSystem;

    /**
     * Container builder provider.
     *
     * @var IContainerBuilder
     */
    private $containerBuilder;

    /**
     * Creates AppBuilder instance.
     *
     * @param IFileSystem       $fileSystem       Provider for file system access.
     * @param IAppPath          $appPath          Provider for application base paths.
     * @param IContainerBuilder $containerBuilder Container builder provider.
     * @param string            $contextName      Name of building context.
     */
    public function __construct(
        IFileSystem $fileSystem,
        IAppPath $appPath,
        IContainerBuilder $containerBuilder,
        $contextName
    ) {
        $this->appPath          = $appPath;
        $this->contextName      = $contextName;
        $this->fileSystem       = $fileSystem;
        $this->containerBuilder = $containerBuilder;

    }

    /**
     * Loads all modules contained in app and builds them.
     *
     * @return void
     */
    protected function loadModules()
    {
        $moduleMask = implode(
            DIRECTORY_SEPARATOR,
            array(
             $this->appPath->root(),
             'src',
             $this->contextName.'Module.php',
            )
        );

        foreach ($this->fileSystem->glob($moduleMask) as $filePath) {
            $class = $this->loadModule($filePath);
            $class->build($this->containerBuilder);
        }

    }

    /**
     * Gets built container.
     *
     * @return IContainer IoC container.
     */
    protected function getContainer()
    {
        if (!$this->container) {
            $this->container = $this->containerBuilder->build();
        }

        return $this->container;

    }

    /**
     * Builds application.
     *
     * @return void
     */
    public function buildApp()
    {
        $this->registerFileSystem();
        $this->registerAppPath();
        $this->loadModules();

    }

    /**
     * Gets logger from application container.
     *
     * @return ILogger The logger implementation.
     */
    public function getLogger()
    {
        return $this->getContainer()->resolve('Conpago\Logging\Contract\ILogger');

    }

    /**
     * Gets application instance.
     *
     * @return IApp The application instance.
     */
    public function getApp()
    {
        return $this->getContainer()->resolve('Conpago\Contract\IApp');

    }

    /**
     * Registers file system access provider. It is required during application build for loading modules.
     *
     * @return void
     */
    private function registerFileSystem()
    {
        $this->containerBuilder->registerInstance($this->fileSystem)->asA('Conpago\File\Contract\IFileSystem');

    }

    /**
     * Registers app paths provider. It is required during application build for loading modules.
     *
     * @return void
     */
    private function registerAppPath()
    {
        $this->containerBuilder->registerInstance($this->appPath)->asA('Conpago\Helpers\Contract\IAppPath');

    }

    /**
     * Loads module class.
     *
     * @param string $filePath Path to module file.
     *
     * @return IModule Loaded module class instance.
     */
    protected function loadModule($filePath)
    {
        return $this->fileSystem->loadClass($filePath);

    }
}
