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

class RequestTest extends \PHPUnit_Framework_TestCase
{
    protected $serverAccessor;
    protected $fileSystem;
    protected $request;

    public function testGetQueryString()
    {
        $this->serverAccessor = $this->createMock(ServerAccessor::class);
        $this->serverAccessor->expects($this->any())->method('contains')->with('QUERY_STRING')->willReturn(true);
        $this->serverAccessor->expects($this->any())->method('getValue')->with('QUERY_STRING')->willReturn('QueryString');

        $this->fileSystem = $this->createMock(IFileSystem::class);

        $this->request = new Request($this->serverAccessor, $this->fileSystem);

        $this->assertEquals('QueryString', $this->request->getQueryString());
    }

    public function testGetPathInfo()
    {
        $this->serverAccessor = $this->createMock(ServerAccessor::class);
        $this->serverAccessor->expects($this->any())->method('contains')->with('PATH_INFO')->willReturn(true);
        $this->serverAccessor->expects($this->any())->method('getValue')->with('PATH_INFO')->willReturn('PathInfo');

        $this->fileSystem = $this->createMock(IFileSystem::class);

        $this->request = new Request($this->serverAccessor, $this->fileSystem);

        $this->assertEquals('PathInfo', $this->request->getPathInfo());
    }

    public function testGetRequestMethod()
    {
        $this->serverAccessor = $this->createMock(ServerAccessor::class);
        $this->serverAccessor->expects($this->any())->method('contains')->with('REQUEST_METHOD')->willReturn(true);
        $this->serverAccessor->expects($this->any())->method('getValue')->with('REQUEST_METHOD')->willReturn('RequestMethod');

        $this->fileSystem = $this->createMock(IFileSystem::class);

        $this->request = new Request($this->serverAccessor, $this->fileSystem);

        $this->assertEquals('RequestMethod', $this->request->getRequestMethod());
    }

    public function testGetContentType()
    {
        $this->serverAccessor = $this->createMock(ServerAccessor::class);
        $this->serverAccessor->expects($this->any())->method('contains')->with('CONTENT_TYPE')->willReturn(true);
        $this->serverAccessor->expects($this->any())->method('getValue')->with('CONTENT_TYPE')->willReturn('ContentType');

        $this->fileSystem = $this->createMock(IFileSystem::class);

        $this->request = new Request($this->serverAccessor, $this->fileSystem);

        $this->assertEquals('ContentType', $this->request->getContentType());
    }

    public function testGetBody()
    {
        $this->serverAccessor = $this->createMock(ServerAccessor::class);

        $this->fileSystem = $this->createMock(IFileSystem::class);
        $this->fileSystem->expects($this->any())->method('getFileContent')->willReturn('body');

        $this->request = new Request($this->serverAccessor, $this->fileSystem);

        $this->assertEquals('body', $this->request->getBody());
    }
}
