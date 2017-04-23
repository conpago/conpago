<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2014-10-15
 * Time: 08:04
 */

namespace Conpago\Helpers;

use Conpago\File\Contract\IFileSystem;
use Conpago\Utils\ServerAccessor;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class RequestTest extends TestCase
{
    /** @var  ServerAccessor | MockObject */
    protected $serverAccessor;

    /** @var  IFileSystem | MockObject */
    protected $fileSystem;

    /** @var Request */
    protected $request;

    public function setUp()
    {
        $this->serverAccessor = $this->createMock(ServerAccessor::class);
        $this->fileSystem = $this->createMock(IFileSystem::class);
        $this->request = new Request($this->serverAccessor, $this->fileSystem);
    }

    public function testGetQueryString()
    {
        $this->serverAccessor->method('contains')->with('QUERY_STRING')->willReturn(true);
        $this->serverAccessor->method('getValue')->with('QUERY_STRING')->willReturn('QueryString');

        $this->assertEquals('QueryString', $this->request->getQueryString());
    }

    public function testGetPathInfo()
    {
        $this->serverAccessor->method('contains')->with('PATH_INFO')->willReturn(true);
        $this->serverAccessor->method('getValue')->with('PATH_INFO')->willReturn('PathInfo');

        $this->assertEquals('PathInfo', $this->request->getPathInfo());
    }

    public function testGetRequestMethod()
    {
        $this->serverAccessor->method('contains')->with('REQUEST_METHOD')->willReturn(true);
        $this->serverAccessor->method('getValue')->with('REQUEST_METHOD')->willReturn('RequestMethod');

        $this->assertEquals('RequestMethod', $this->request->getRequestMethod());
    }

    public function testGetContentType()
    {
        $this->serverAccessor->method('contains')->with('CONTENT_TYPE')->willReturn(true);
        $this->serverAccessor->method('getValue')->with('CONTENT_TYPE')->willReturn('ContentType');

        $this->assertEquals('ContentType', $this->request->getContentType());
    }

    public function testGetAccept()
    {
        $this->serverAccessor->method('contains')->with('ACCEPT')->willReturn(true);
        $this->serverAccessor->method('getValue')->with('ACCEPT')->willReturn('application/json');

        $this->assertEquals('application/json', $this->request->getAccept());
    }

    public function testGetBody()
    {
        $this->fileSystem->method('getFileContent')->willReturn('body');

        $this->assertEquals('body', $this->request->getBody());
    }

    public function test_GetQueryString_ShouldReturnNull_IfServerAccessorContainsWillReturnFalse()
    {
        $this->serverAccessor->method('contains')->with('QUERY_STRING')->willReturn(false);

        $this->assertEquals(null, $this->request->getQueryString());
    }

    public function test_GetPathInfo_ShouldReturnNull_IfServerAccessorContainsWillReturnFalse()
    {
        $this->serverAccessor->method('contains')->with('PATH_INFO')->willReturn(false);

        $this->assertEquals(null, $this->request->getPathInfo());
    }

    public function test_GetRequestMethod_ShouldReturnNull_IfServerAccessorContainsWillReturnFalse()
    {
        $this->serverAccessor->method('contains')->with('REQUEST_METHOD')->willReturn(false);

        $this->assertEquals(null, $this->request->getRequestMethod());
    }

    public function test_GetContentType_ShouldReturnNull_IfServerAccessorContainsWillReturnFalse()
    {
        $this->serverAccessor->method('contains')->with('CONTENT_TYPE')->willReturn(false);

        $this->assertEquals(null, $this->request->getContentType());
    }

    public function test_GetAccept_ShouldReturnNull_IfServerAccessorContainsWillReturnFalse()
    {
        $this->serverAccessor->method('contains')->with('ACCEPT')->willReturn(false);

        $this->assertEquals(null, $this->request->getAccept());
    }
}
