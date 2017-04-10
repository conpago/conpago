<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-19
 * Time: 23:39
 */

namespace Conpago\Core;

use Conpago\Helpers\Contract\IRequestData;
use Conpago\Helpers\Contract\IRequestParser;
use PHPUnit\Framework\TestCase;

class RequestDataReaderTest extends TestCase
{
    public function testGetRequestData()
    {
        $requestData = $this->createMock(IRequestData::class);
        $requestParser = $this->createMock(IRequestParser::class);
        $requestParser->expects($this->once())->method('parseRequestData')->willReturn($requestData);

        $requestDataReader = new RequestProvider($requestParser);
        $this->assertSame($requestData, $requestDataReader->getRequestData());
    }
}
