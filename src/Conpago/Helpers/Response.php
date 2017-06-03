<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-19
 * Time: 23:54
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Helpers;

use Conpago\Helpers\Contract\IResponse;

/**
 * Helper class for setting response parameters.
 */
class Response implements IResponse
{

    /**
     * Sets http response code.
     *
     * @param integer $code Http response code.
     *
     * @return void
     */
    public function setHttpResponseCode($code)
    {
        http_response_code($code);
    }

    /**
     * Set content type.
     *
     * @param string $contentType Http content type.
     *
     * @return void
     */
    public function setContentType($contentType)
    {
        header('Content-Type: '.$contentType);
    }
}
