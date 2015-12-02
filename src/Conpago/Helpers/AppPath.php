<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 09.11.13
 * Time: 15:30
 */

namespace Conpago\Helpers;

use Conpago\File\Contract\IFileSystem;
use Conpago\File\Contract\IPath;
use Conpago\File\Path;
use Conpago\Helpers\Contract\IAppPath;

class AppPath implements IAppPath
{

    protected $cache;
    protected $config;
    protected $root;
    protected $templates;
    protected $source;
    protected $sessions;

    /**
     * @var IFileSystem
     */
    private $fileSystem;

    public function __construct(IFileSystem $fileSystem, $basePath)
    {
        $this->fileSystem = $fileSystem;

        $this->source    = array($basePath, "src");
        $this->templates = array($basePath, "templates");
        $this->root      = array($basePath);
        $this->config    = array($basePath, "config" );
        $this->cache     = array($basePath, "tmp", "cache");
        $this->sessions  = array($basePath, "tmp", "sessions");
    }

    /**
     * @return IPath
     */
    private function getPath(array $elements)
    {
        $path = implode(DIRECTORY_SEPARATOR, $elements);
        $realPath = $this->fileSystem->realPath($path);
        return new Path($path, $realPath);
    }

    /**
     * @return IPath
     */
    public function cache()
    {
        return $this->getPath($this->cache);
    }

    /**
     * @return IPath
     */
    public function sessions()
    {
        return $this->getPath($this->sessions);
    }

    /**
     * @return IPath
     */
    public function config()
    {
        return $this->getPath($this->config);
    }

    /**
     * @return IPath
     */
    public function root()
    {
        return $this->getPath($this->root);
    }

    /**
     * @return IPath
     */
    public function templates()
    {
        return $this->getPath($this->templates);
    }

    /**
     * @return IPath
     */
    public function source()
    {
        return $this->getPath($this->source);
    }
}
