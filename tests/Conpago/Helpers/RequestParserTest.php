<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-15
 * Time: 23:02
 */

namespace Conpago\Helpers;

use BadMethodCallException;
use Conpago\Core\RequestData;
use Conpago\Helpers\Contract\IRequest;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class RequestParserTest extends TestCase
{
    /** @var Request | MockObject */
    private $request;

    /** @var RequestParser */
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
        $this->doTestRequestParser('html', [], '', []);
    }

    public function testEmptyJsonRequest()
    {
        $this->setContentType('application/json');
        $this->doTestRequestParser('json', array(), '', array());
    }

    public function testJsonRequestWithUrlElements()
    {
        $this->setContentType('application/json');
        $this->setPathInfo('path/info');
        $this->doTestRequestParser('json', array(), '', array('path', 'info'));
    }

    public function testJsonRequestWithRequestMethod()
    {
        $this->setContentType('application/json');
        $this->setRequestMethod('requestMethod');
        $this->doTestRequestParser('json', array(), 'requestMethod', array());
    }

    public function testJsonRequestWithQueryString()
    {
        $this->setContentType('application/json');
        $this->setQueryString('a=1&b=2');
        $this->doTestRequestParser('json', array('a' => 1, 'b' => 2), '', array());
    }

    public function testJsonRequestWithSimpleBody()
    {
        $this->setContentType('application/json');
        $body = json_encode(array(
                    'a' => 1,
                    'b' => 2
                ));
        $this->setBody($body);
        $this->doTestRequestParser('json', array('a' => 1, 'b' => 2), '', array());
    }

    public function testJsonRequestWithTreeBody()
    {
        $this->setContentType('application/json');
        $body = json_encode(array('a' => array('a' => '1.1', 'b' => '1.2'), 'b' => 2));
        $this->setBody($body);
        $this->doTestRequestParser('json', array('a' => array('a' => '1.1', 'b' => '1.2'), 'b' => 2), '', array());
    }

    public function testJsonRequestIntegration()
    {
        $this->setContentType('application/json');
        $this->setPathInfo('path/info');
        $this->setRequestMethod('requestMethod');
        $this->setQueryString('a=1&b=2');

        $body = json_encode(array('a' => array('a' => '1.1', 'b' => '1.2'), 'b' => 2));
        $this->setBody($body);

        $this->doTestRequestParser(
            'json',
            array('a' => array('a' => '1.1', 'b' => '1.2'), 'b' => 2),
            'requestMethod',
            array('path', 'info')
        );
    }

    public function testEmptyHtmlRequest()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $this->doTestRequestParser('html', array(), '', array());
    }

    public function testHtmlRequestWithUrlElements()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $this->setPathInfo('path/info');
        $this->doTestRequestParser('html', array(), '', array('path', 'info'));
    }

    public function testHtmlRequestWithRequestMethod()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $this->setRequestMethod('requestMethod');
        $this->doTestRequestParser('html', array(), 'requestMethod', array());
    }

    public function testHtmlRequestWithQueryString()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $this->setQueryString('a=1&b=2');
        $this->doTestRequestParser('html', array('a' => 1, 'b' => 2), '', array());
    }

    public function testHtmlRequestWithSimpleBody()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $body = 'a=1&b=2';
        $this->setBody($body);
        $this->doTestRequestParser('html', array('a' => 1, 'b' => 2), '', array());
    }

    public function testHtmlRequestWithTreeBody()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $body = 'a.a=1.1&a.b=1.2&b=2';
        $this->setBody($body);
        $this->doTestRequestParser('html', array('a' => array('a' => '1.1', 'b' => '1.2'), 'b' => 2), '', array());
    }

    public function testHtmlRequestWithDeepTreeBody()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $body = 'a.a.a=1.1.1&a.a.b=1.1.2';
        $this->setBody($body);
        $this->doTestRequestParser('html', ['a' => ['a' => ['a' => '1.1.1', 'b' => '1.1.2']]], '', []);
    }

    public function testHtmlRequestIntegration()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $this->setPathInfo('path/info');
        $this->setRequestMethod('requestMethod');
        $this->setQueryString('a=1&b=2');

        $body = 'a=2&b=1&c.a=3&c.b=4&d=5&d=6';
        $this->setBody($body);

        $this->doTestRequestParser(
            'html',
            array(
                    'a' => '2',
                    'b' => '1',
                    'c' => array(
                        'a' => '3',
                        'b' => '4'
                    ),
                    'd' => array('5', '6')),
            'requestMethod',
            array('path', 'info')
        );
    }

    public function testHtmlRequestWithArrayBody()
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $body = 'a=1&a=2&a=3';
        $this->setBody($body);
        $this->doTestRequestParser('html', array('a' => array('1', '2', '3')), '', array());
    }

        /**
         * @param RequestData $requestData
         * @param $format
         * @param $parameters
         * @param $requestMethod
         * @param $urlElements
         */
    protected function assertRequestData(RequestData $requestData, $format, $parameters, $requestMethod, $urlElements)
    {
        $this->assertEquals(
            array(
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
            )
        );
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
    private function doTestRequestParser($format, $parameters, $requestMethod, $urlElements)
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
