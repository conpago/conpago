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
    private $_contextName;

    /**
     * @var IFileSystem
     */
    private $_fileSystem;

    /**
     * @var IContainerBuilder
     */
    private $_containerBuilder;

    /**
     * @param IFileSystem       $fileSystem
     * @param IAppPath          $appPath
     * @param IContainerBuilder $containerBuilder
     * @param string            $contextName
     */
    public function __construct(
        IFileSystem $fileSystem,
        IAppPath $appPath,
        IContainerBuilder $containerBuilder,
        $contextName
    ) {
        $this->appPath          = $appPath;
        $this->_contextName      = $contextName;
        $this->_fileSystem       = $fileSystem;
        $this->_containerBuilder = $containerBuilder;

    }

    protected function loadModules()
    {
        $moduleMask = implode(
            DIRECTORY_SEPARATOR,
            array(
             $this->appPath->root(),
             'src',
             $this->_contextName.'Module.php',
            )
        );

        foreach ($this->_fileSystem->glob($moduleMask) as $filePath) {
            /*
                @var IModule $class
*/
            $class = $this->_fileSystem->loadClass($filePath);
            $class->build($this->_containerBuilder);
        }

    }

    /**
     * @var IModule[]
     */
    protected $additionalModules = array();

    public function registerAdditionalModule(IModule $module)
    {
        $this->additionalModules[] = $module;

    }

    protected function loadAdditionalModules()
    {
        foreach ($this->additionalModules as $additionalModule) {
            $additionalModule->build($this->_containerBuilder);
        }

    }

    /**
     * @return IContainer
     */
    protected function getContainer()
    {
        if (!$this->container) {
            $this->container = $this->_containerBuilder->build();
        }

        return $this->container;

    }

    public function buildApp()
    {
        $this->_registerFileSystem();
        $this->_registerAppPath();
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

    private function _registerFileSystem()
    {
        $this->_containerBuilder->registerInstance($this->_fileSystem)->asA('Conpago\File\Contract\IFileSystem');

    }

    /**
     * Register IAppPath implementation in container.
     */
    private function _registerAppPath()
    {
        $this->_containerBuilder->registerInstance($this->appPath)->asA('Conpago\Helpers\Contract\IAppPath');

    }
}
