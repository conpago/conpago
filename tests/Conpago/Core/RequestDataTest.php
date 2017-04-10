<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2014-10-17
 * Time: 08:03
 */

namespace Conpago\Core;

use PHPUnit\Framework\TestCase;

class RequestDataTest extends TestCase
{
    public function testFormat()
    {
        $this->assertEquals('format', (new Request([], null, 'format', []))->getFormat());
    }

    public function testParameters()
    {
        $this->assertEquals(['parameters'], (new Request([], null, null, ['parameters']))->getParameters());
    }

    public function testRequestMethod()
    {
        $this->assertEquals('requestMethod', (new Request([], 'requestMethod', null, ['parameters']))->getRequestMethod());
    }

    public function testUrlElements()
    {
        $this->assertEquals(['urlElements'], (new Request(['urlElements'], null, null, []))->getUrlElements());
    }
}
