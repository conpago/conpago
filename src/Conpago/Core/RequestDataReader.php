<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 25.02.14
 * Time: 07:51
 */

namespace Conpago\Core;

use Conpago\Helpers\Contract\IRequestData;
use Conpago\Helpers\Contract\IRequestDataReader;
use Conpago\Helpers\Contract\IRequestParser;

class RequestDataReader implements IRequestDataReader
{
    /**
     * @var Conpago\Helpers\Contract\IRequestData
     */
    protected $requestData;

    /**
     * @param IRequestParser $requestParser
     */
    public function __construct(IRequestParser $requestParser)
    {
        $this->requestParser = $requestParser;
    }

    /**
     * @return IRequestData
     */
    public function getRequestData()
    {
        if ($this->requestData == null) {
            $this->requestData = $this->requestParser->parseRequestData();
        }

        return $this->requestData;
    }

    /**
     * @var IRequestParser
     */
    private $requestParser;
}
