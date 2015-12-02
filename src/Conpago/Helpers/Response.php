<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-19
 * Time: 23:54
 */

namespace Conpago\Helpers;

use Conpago\Helpers\Contract\IResponse;

class Response implements IResponse
{

    public function setHttpResponseCode($code)
    {
        http_response_code($code);
    }
}
