<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2014-10-15
 * Time: 08:04
 */

namespace Conpago\Helpers;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    public function testGetQueryString()
    {
        $this->serverAccessor->expects($this->any())->method('contains')->with('QUERY_STRING')->willReturn(true);
        $this->serverAccessor->expects($this->any())->method('getValue')->with('QUERY_STRING')->willReturn('QueryString');
        $this->assertEquals('QueryString', $this->request->getQueryString());
    }

    public function testGetNonExistingValue()
    {
        $this->serverAccessor->expects($this->any())->method('contains')->with('QUERY_STRING')->willReturn(false);
        $this->assertNull($this->request->getQueryString());
    }

    public function testGetPathInfo()
    {
        $this->serverAccessor->expects($this->any())->method('contains')->with('PATH_INFO')->willReturn(true);
        $this->serverAccessor->expects($this->any())->method('getValue')->with('PATH_INFO')->willReturn('PathInfo');
        $this->assertEquals('PathInfo', $this->request->getPathInfo());
    }

    public function testGetRequestMethod()
    {
        $this->serverAccessor->expects($this->any())->method('contains')->with('REQUEST_METHOD')->willReturn(true);
        $this->serverAccessor->expects($this->any())->method('getValue')->with('REQUEST_METHOD')->willReturn('RequestMethod');
        $this->assertEquals('RequestMethod', $this->request->getRequestMethod());
    }

    public function testGetContentType()
    {
        $this->serverAccessor->expects($this->any())->method('contains')->with('CONTENT_TYPE')->willReturn(true);
        $this->serverAccessor->expects($this->any())->method('getValue')->with('CONTENT_TYPE')->willReturn('ContentType');
        $this->assertEquals('ContentType', $this->request->getContentType());
    }

    public function testGetBody()
    {
        $this->fileSystem->expects($this->any())->method('getFileContent')->willReturn('body');
        $this->assertEquals('body', $this->request->getBody());
    }

    public function setUp()
    {
        $this->serverAccessor = $this->getMock('Conpago\Utils\ServerAccessor');
        $this->fileSystem     = $this->getMock('Conpago\File\Contract\IFileSystem');
        $this->request        = new Request($this->serverAccessor, $this->fileSystem);
    }
}
