<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-06-15
 * Time: 10:38
 */

namespace Conpago\Presentation;

use Conpago\Helpers\Contract\IResponse;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class JsonPresenterTest extends TestCase
{
    /** @var IResponse | MockObject */
    private $responseMock;

    public function testShowJsonShouldPrintJsonDataIfArrayIsPassed()
    {
        $this->expectOutputString('{"test":"a"}');

        $jsonPresenter = new JsonPresenter($this->responseMock);
        $jsonPresenter->showJson(['test' => 'a']);
    }

    public function testShowJsonShouldCallResponseSetContentTypeWithProperContentType()
    {
        $this->responseMock
            ->expects($this->once())
            ->method('setContentType')
            ->with('application/json');

        $jsonPresenter = new JsonPresenter($this->responseMock);
        $jsonPresenter->showJson(['test' => 'a']);
    }

    public function setUp()
    {
        $this->responseMock = $this->createMock(IResponse::class);
    }
}
