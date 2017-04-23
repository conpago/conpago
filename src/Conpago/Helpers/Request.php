<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 09.11.13
 * Time: 15:30
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Helpers;

use Conpago\File\Contract\IFileSystem;
use Conpago\Helpers\Contract\IRequest;
use Conpago\Utils\ServerAccessor;

/**
 * Provides access to request properties.
 */
class Request implements IRequest
{

    /**
     * $_SERVER array operations access provider.
     * @var ServerAccessor
     */
    private $serverAccessor;

    /**
     * File system operations provider.
     * @var IFileSystem
     */
    private $fileSystem;

    /**
     * Creates
     *
     * @param ServerAccessor $serverAccessor Static $_SERVER array operations access provider.
     * @param IFileSystem    $fileSystem     File system operations provider.
     */
    public function __construct(ServerAccessor $serverAccessor, IFileSystem $fileSystem)
    {
        $this->serverAccessor = $serverAccessor;
        $this->fileSystem     = $fileSystem;
    }

    /**
     * Gets named http request value.
     *
     * @param string $name Name of property.
     *
     * @return mixed Value of property or null if not exists.
     */
    private function getValue($name)
    {
        if (!$this->serverAccessor->contains($name)) {
            return null;
        }

        return $this->serverAccessor->getValue($name);
    }

    /**
     * Gets http request method.
     *
     * @return string Http request method.
     */
    public function getRequestMethod()
    {
        return $this->getValue('REQUEST_METHOD');
    }

    /**
     * Gets http request path info.
     *
     * @return string Http request path info.
     */
    public function getPathInfo()
    {
        return $this->getValue('PATH_INFO');
    }

    /**
     * Gets http request query string.
     *
     * @return string Http request query string.
     */
    public function getQueryString()
    {
        return $this->getValue('QUERY_STRING');
    }

    /**
     * Gets http request content type.
     *
     * @return string Http request content type.
     */
    public function getContentType()
    {
        return $this->getValue('CONTENT_TYPE');
    }

    /**
     * Gets http request body.
     *
     * @return string Http request body.
     */
    public function getBody()
    {
        return $this->fileSystem->getFileContent('php://input');
    }

    /**
     * Get accept.
     *
     * @return string Returns accept header value.
     */
    public function getAccept()
    {
        return $this->getValue('ACCEPT');
    }
}
