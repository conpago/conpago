<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-15
 * Time: 23:02
 */

namespace Conpago\Helpers;

use BadMethodCallException;
use Conpago\Helpers\Contract\IRequest;

class RequestParserTest extends \PHPUnit_Framework_TestCase
{
    private $request;

    private $requestParser;

    protected function setUp()
    {
        $this->request = $this->createMock(IRequest::class);
        $this->requestParser = new RequestParser($this->request);
    }

    public function testThrowsBadMethodCallExceptionFor()
    {
        $this->expectException(BadMethodCallException::class);
        $this->request->expects($this->any())->method('getContentType')->willReturn('bad content type');

        $requestParser = new RequestParser($this->request);
        $requestParser->parseRequestData();
    }

    public function testEmptyRequest()
    {
        $this->setUp();
        $this->_testRequestParser('html', array(), '', array());
    }

    public function testEmptyJsonRequest()
    {
        $this->setUp();
        $this->setContentType('application/json');
        $this->_testRequestParser('json', array(), '', array());
    }

    public function testJsonRequestWithUrlElements()
    {
        $this->setContentType('application/json');
        $this->setPathInfo('path/info');
        $this->_testRequestParser('json', array(), '', array('path', 'info'));
    }

    public function testJsonRequestWithRequestMethod()
    {
        $this->setContentType('application/json');
        $this->setRequestMethod('requestMethod');
        $this->_testRequestParser('json', array(), 'requestMethod', array());
    }

    public function testJsonRequestWithQueryString()
    {
        $this->setContentType('application/json');
        $this->setQueryString('a=1&b=2');
        $this->_testRequestParser('json', array('a' => 1, 'b' => 2), '', array());
    }

    public function testJsonRequestWithSimpleBody()
    {
        $this->setContentType('application/json');
        $body = json_encode(array(
                    'a' => 1,
                    'b' => 2
                ));
        $this->setBody($body);
        $this->_testRequestParser('json', array('a' => 1, 'b' => 2), '', array());
    }

    public function testJsonRequestWithTreeBody()
    {
        $this->setContentType('application/json');
        $body = json_encode(array('a' => array('a' => '1.1', 'b' => '1.2'), 'b' => 2));
        $this->setBody($body);
        $this->_testRequestParser('json', array('a' => array('a' => '1.1', 'b' => '1.2'), 'b' => 2), '', array());
    }

    public function testJsonRequestIntegration()
    {
        $this->setContentType('application/json');
        $this->setPathInfo('path/info');
        $this->setRequestMethod('requestMethod');
        $this->setQueryString('a=1&b=2');

        $body = json_encode(array('a' => array('a' => '1.1', 'b' => '1.2'), 'b' => 2));
        $this->setBody($body);

        $this->_testRequestParser('json',
                array('a' => array('a' => '1.1', 'b' => '1.2'), 'b' => 2),
                'requestMethod',
                array('path', 'info'));
    }

    public function testEmptyHtmlRequest()
    {
        $this->setUp();
        $this->setContentType('application/x-www-form-urlencoded');
        $this->_testRequestParser('html', array(), '', array());
    }

    public function testHtmlRequestWithUrlElements()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $this->setPathInfo('path/info');
        $this->_testRequestParser('html', array(), '', array('path', 'info'));
    }

    public function testHtmlRequestWithRequestMethod()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $this->setRequestMethod('requestMethod');
        $this->_testRequestParser('html', array(), 'requestMethod', array());
    }

    public function testHtmlRequestWithQueryString()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $this->setQueryString('a=1&b=2');
        $this->_testRequestParser('html', array('a' => 1, 'b' => 2), '', array());
    }

    public function testHtmlRequestWithSimpleBody()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $body = 'a=1&b=2';
        $this->setBody($body);
        $this->_testRequestParser('html', array('a' => 1, 'b' => 2), '', array());
    }

    public function testHtmlRequestWithTreeBody()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $body = 'a.a=1.1&a.b=1.2&b=2';
        $this->setBody($body);
        $this->_testRequestParser('html', array('a' => array('a' => '1.1', 'b' => '1.2'), 'b' => 2), '', array());
    }

    public function testHtmlRequestWithDeepTreeBody()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $body = 'a.a.a=1.1.1&a.a.b=1.1.2';
        $this->setBody($body);
        $this->_testRequestParser('html', array('a' => array('a' => array('a' => '1.1.1', 'b' => '1.1.2'))), '', array());
    }

    public function testHtmlRequestIntegration()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $this->setPathInfo('path/info');
        $this->setRequestMethod('requestMethod');
        $this->setQueryString('a=1&b=2');

        $body = 'a=2&b=1&c.a=3&c.b=4&d=5&d=6';
        $this->setBody($body);

        $this->_testRequestParser('html',
                array(
                    'a' => '2',
                    'b' => '1',
                    'c' => array(
                        'a' => '3',
                        'b' => '4'
                    ),
                    'd' => array('5', '6')),
                'requestMethod',
                array('path', 'info'));
    }

    public function testHtmlRequestWithArrayBody()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $body = 'a=1&a=2&a=3';
        $this->setBody($body);
        $this->_testRequestParser('html', array('a' => array('1', '2', '3')), '', array());
    }

        /**
         * @param $requestData
         * @param $format
         * @param $parameters
         * @param $requestMethod
         * @param $urlElements
         */
        protected function assertRequestData($requestData, $format, $parameters, $requestMethod, $urlElements)
        {
            $this->assertEquals(array(
                    'getFormat' => $format,
                    'getParameters' => $parameters,
                    'getRequestMethod' => $requestMethod,
                    'getUrlElements' => $urlElements
                ),
                array(
                    'getFormat' => $requestData->getFormat(),
                    'getParameters' => $requestData->getParameters(),
                    'getRequestMethod' => $requestData->getRequestMethod(),
                    'getUrlElements' => $requestData->getUrlElements()
                ));
        }

        /**
         * @param $contentType
         *
         * @return mixed
         */
        protected function setContentType($contentType)
        {
            return $this->request->expects($this->any())->method('getContentType')->willReturn($contentType);
        }

        /**
         * @param $format
         * @param $parameters
         * @param $requestMethod
         * @param $urlElements
         */
        protected function _testRequestParser($format, $parameters, $requestMethod, $urlElements)
        {
            $requestData = $this->requestParser->parseRequestData();
            $this->assertRequestData($requestData, $format, $parameters, $requestMethod, $urlElements);
        }

        /**
         * @param $pathInfo
         */
        protected function setPathInfo($pathInfo)
        {
            $this->request->expects($this->any())->method('getPathInfo')->willReturn($pathInfo);
        }

        /**
         * @param $requestMethod
         */
        protected function setRequestMethod($requestMethod)
        {
            $this->request->expects($this->any())->method('getRequestMethod')->willReturn($requestMethod);
        }

        /**
         * @param $queryString
         */
        protected function setQueryString($queryString)
        {
            $this->request->expects($this->any())->method('getQueryString')->willReturn($queryString);
        }

        /**
         * @param $body
         */
        protected function setBody($body)
        {
            $this->request->expects($this->any())->method('getBody')->willReturn($body);
        }
}
