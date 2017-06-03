<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-17
 * Time: 08:03
 */

namespace Conpago\Core;

use PHPUnit\Framework\TestCase;

class RequestDataTest extends TestCase
{
    public function testFormat()
    {
        $this->assertEquals('format', (new RequestData([], null, 'format', []))->getFormat());
    }

    public function testParameters()
    {
        $this->assertEquals(['parameters'], (new RequestData([], null, null, ['parameters']))->getParameters());
    }

    public function testRequestMethod()
    {
        $this->assertEquals(
            'requestMethod',
            (new RequestData([], 'requestMethod', null, ['parameters']))->getRequestMethod()
        );
    }

    public function testUrlElements()
    {
        $this->assertEquals(['urlElements'], (new RequestData(['urlElements'], null, null, []))->getUrlElements());
    }
}
