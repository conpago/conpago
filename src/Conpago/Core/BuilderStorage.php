<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 13.11.13
 * Time: 20:38
 *
 * @package    Conpago
 * @subpackage Core
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Core;

use Conpago\DI\IContainerBuilderStorage;
use Conpago\File\Contract\IFileSystem;
use Conpago\Helpers\Contract\IAppPath;

/**
 * Provides mechanism to save serialized container to file and reopen it.
 */
class BuilderStorage implements IContainerBuilderStorage
{

    /**
     * Name of serialisation file.
     *
     * @var string
     */
    private $fileName;

    /**
     * File system access provider.
     *
     * @var IFileSystem
     */
    private $filesystem;

    /**
     * Creates new instance of storage.
     *
     * @param IFileSystem $filesystem  File system access provider.
     * @param IAppPath    $appPath     Application path provider.
     * @param string      $contextName Application working context name.
     */
    public function __construct(IFileSystem $filesystem, IAppPath $appPath, $contextName)
    {
        $this->filesystem = $filesystem;
        $this->fileName   = implode(
            DIRECTORY_SEPARATOR,
            array(
             $appPath->root(),
             'tmp',
             'persistent',
             $contextName.'Container',
            )
        );

    }

    /**
     * Puts serialized data to file.
     *
     * @param array $configuration Container configuration data to serialize.
     *
     * @return void
     */
    public function putConfiguration(array $configuration)
    {
        $this->filesystem->setFileContent($this->fileName, serialize($configuration));

    }

    /**
     * Gets container configuration data from file.
     *
     * @return array Container configuration data.
     */
    public function getConfiguration()
    {
        return unserialize($this->filesystem->getFileContent($this->fileName));

    }
}
