<?php
    /**
     * Created by PhpStorm.
     * User: bgolek
     * Date: 2014-10-17
     * Time: 08:03
     */

    namespace Conpago\Core;

class RequestDataTest extends \PHPUnit_Framework_TestCase
{
    /**
         * @var RequestData
         */
        private $requestData;

    public function setUp()
    {
        $this->requestData = new RequestData();
    }

    public function testFormat()
    {
        $this->requestData->setFormat('format');
        $this->assertEquals('format', $this->requestData->getFormat());
    }

    public function testParameters()
    {
        $this->requestData->setParameters('parameters');
        $this->assertEquals('parameters', $this->requestData->getParameters());
    }

    public function testRequestMethod()
    {
        $this->requestData->setRequestMethod('requestMethod');
        $this->assertEquals('requestMethod', $this->requestData->getRequestMethod());
    }

    public function testUrlElements()
    {
        $this->requestData->setUrlElements('urlElements');
        $this->assertEquals('urlElements', $this->requestData->getUrlElements());
    }
}
