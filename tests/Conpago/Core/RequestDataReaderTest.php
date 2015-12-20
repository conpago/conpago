<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-19
 * Time: 23:39
 */

namespace Conpago\Core;

class RequestDataReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRequestData()
    {
        $requestData = $this->getMock('Conpago\Helpers\Contract\IRequestData');
        $requestParser = $this->getMock('Conpago\Helpers\Contract\IRequestParser');
        $requestParser->expects($this->once())->method('parseRequestData')->willReturn($requestData);

        $requestDataReader = new RequestDataReader($requestParser);
        $this->assertSame($requestData, $requestDataReader->getRequestData());
    }
}
