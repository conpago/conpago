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

namespace Conpago\Core;

use Conpago\Helpers\Contract\IRequestData;

/**
 * Represents current request specified data.
 */
class RequestData implements IRequestData
{

    /**
     * Creates new RequestData instance.
     *
     * @param string[] $urlElements   Elements of requested Url.
     * @param string   $requestMethod Request http method.
     * @param string   $format        Request data format.
     * @param string[] $parameters    Request parameters read from url and body.
     */
    public function __construct(array $urlElements, $requestMethod, $format, array $parameters)
    {
        $this->urlElements   = $urlElements;
        $this->requestMethod = $requestMethod;
        $this->format        = $format;
        $this->parameters    = $parameters;

    }

    /**
     * Elements of requested Url.
     *
     * @var string[]
     */
    private $urlElements;

    /**
     * Request http method.
     *
     * @var string
     */
    private $requestMethod;

    /**
     * Request data format.
     *
     * @var string
     */
    private $format;

    /**
     * Request parameters read from url and body.
     *
     * @var string[]
     */
    private $parameters;

    /**
     * Gets elements of requested Url.
     *
     * @return string[] Elements of requested Url.
     */
    public function getUrlElements()
    {
        return $this->urlElements;

    }

    /**
     * Gets request http method.
     *
     * @return string Request http method.
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;

    }

    /**
     * Gets request parameters read from url and body.
     *
     * @return string[] Request parameters read from url and body.
     */
    public function getParameters()
    {
        return $this->parameters;

    }

    /**
     * Gets request data format
     *
     * @return string Request data format.
     */
    public function getFormat()
    {
        return $this->format;

    }
}
