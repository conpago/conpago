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

class BuilderStorage implements IContainerBuilderStorage
{

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var IFileSystem
     */
    private $filesystem;

    /**
     * @param IFileSystem $filesystem
     * @param IAppPath    $appPath
     * @param string      $contextName
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

    public function putConfiguration(array $configuration)
    {
        $results = print_r($configuration, true);

        $results = '<?php'.PHP_EOL.'return '.str_replace('    ', "\t", $results);

        $this->filesystem->setFileContent($this->fileName, $results);

    }

    public function getConfiguration()
    {
        return $this->filesystem->includeFile($this->fileName);

    }
}
