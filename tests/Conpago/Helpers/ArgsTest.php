<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2014-10-13
 * Time: 07:59
 */

namespace Conpago\Helpers;

use Conpago\Utils\ServerAccessor;
use PHPUnit\Framework\TestCase;

class ArgsTest extends TestCase
{
    private $args;

    private $serverAccessor;

    public function testOnlyScript()
    {
        $this->serverAccessor = $this->createMock(ServerAccessor::class);
        $this->serverAccessor->expects($this->any())->method('contains')->with('argv')->willReturn(true);
        $this->serverAccessor->expects($this->any())->method('getValue')->with('argv')->willReturn(array('script'));

        $this->args = new Args($this->serverAccessor);

        $this->assertEquals('script', $this->args->getScript());
    }

    public function testNoArgv()
    {
        $this->serverAccessor = $this->createMock(ServerAccessor::class);
        $this->serverAccessor->expects($this->any())->method('contains')->with('argv')->willReturn(false);
        $this->serverAccessor->expects($this->never())->method('getValue')->with('argv');

        $this->args = new Args($this->serverAccessor);
    }

    public function testScriptWithArgs()
    {
        $this->serverAccessor = $this->createMock(ServerAccessor::class);
        $this->serverAccessor->expects($this->any())->method('contains')->with('argv')->willReturn(true);
        $this->serverAccessor->expects($this->any())->method('getValue')->with('argv')->willReturn(array('script', 'arg1', 'arg2'));

        $this->args = new Args($this->serverAccessor);

        $this->assertEquals(array('arg1', 'arg2'), $this->args->getArguments());
    }

    public function testScriptWithOption()
    {
        $this->serverAccessor = $this->createMock(ServerAccessor::class);
        $this->serverAccessor->expects($this->any())->method('contains')->with('argv')->willReturn(true);
        $this->serverAccessor->expects($this->any())->method('getValue')->with('argv')->willReturn(array('script', '-o1', 'option1'));

        $this->args = new Args($this->serverAccessor);

        $this->assertEquals(true, $this->args->hasOption('o1'));
        $this->assertEquals('option1', $this->args->getOption('o1'));
    }
}
