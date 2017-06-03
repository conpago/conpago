<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-20
 * Time: 00:10
 *
 * @package    Conpago
 * @subpackage Core
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago;

use Conpago\DI\ContainerBuilder;
use Conpago\DI\IContainerBuilderPersister;
use Conpago\File\FileSystem;
use Conpago\Helpers\AppPath;

/**
 * Provides a factory for creating AppBuilder.
 */
class AppBuilderFactory
{

    /**
     * Creates AppBuilder using newly built container.
     *
     * @param string $contextName Name of context. Passed to AppBuilder instance.
     * @param string $appRootPath Base path of source files. Passed to AppPath class for instance.
     *
     * @return AppBuilder Builder of application.
     */
    public function createAppBuilder($contextName, $appRootPath)
    {
        list($fileSystem, $containerBuilder, $appPath) = $this->getAppBuilderDependencies($appRootPath);
        return new AppBuilder($fileSystem, $appPath, $containerBuilder, $contextName);
    }

    /**
     * Creates AppBuilder from loaded persisted container.
     *
     * @param IContainerBuilderPersister $persister   Container persister used to load persisted container.
     * @param string                     $contextName Name of context. Passed to AbbBuilder instance.
     * @param string                     $appRootPath Base path of source files. Passed to AppPath class for instance.
     *
     * @return AppBuilder Builder of application.
     */
    public function createAppBuilderFromPersisted(IContainerBuilderPersister $persister, $contextName, $appRootPath)
    {
        $fileSystem       = new FileSystem();
        $appPath          = new AppPath($fileSystem, $appRootPath);
        $containerBuilder = $persister->loadContainerBuilder();

        return new AppBuilder($fileSystem, $appPath, $containerBuilder, $contextName);
    }

    /**
     * Returns all dependencies needed by AppBuilder as array.
     *
     * @param string $appRootPath Base path of source files.
     *
     * @return array All dependencies needed by AppBuilder as array.
     */
    protected function getAppBuilderDependencies($appRootPath)
    {
        $fileSystem       = new FileSystem();
        $containerBuilder = new ContainerBuilder();
        $appPath          = new AppPath($fileSystem, $appRootPath);

        return array(
                $fileSystem,
                $containerBuilder,
                $appPath,
               );
    }
}
