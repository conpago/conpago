<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-13
	 * Time: 07:59
	 */

	namespace Saigon\Conpago\Helpers;


	class ArgsTest extends \PHPUnit_Framework_TestCase
	{
		private $args;

		private $serverAccessor;

		function testOnlyScript()
		{
			$this->serverAccessor = $this->getMock('Saigon\Conpago\Accessor\ServerAccessor');
			$this->serverAccessor->expects($this->any())->method('contains')->with('argv')->willReturn(true);
			$this->serverAccessor->expects($this->any())->method('getValue')->with('argv')->willReturn(array('script'));

			$this->args = new Args($this->serverAccessor);

			$this->assertEquals('script', $this->args->getScript());
		}

		function testNoArgv()
		{
			$this->serverAccessor = $this->getMock('Saigon\Conpago\Accessor\ServerAccessor');
			$this->serverAccessor->expects($this->any())->method('contains')->with('argv')->willReturn(false);
			$this->serverAccessor->expects($this->never())->method('getValue')->with('argv');

			$this->args = new Args($this->serverAccessor);
		}

		function testScriptWithArgs()
		{
			$this->serverAccessor = $this->getMock('Saigon\Conpago\Accessor\ServerAccessor');
			$this->serverAccessor->expects($this->any())->method('contains')->with('argv')->willReturn(true);
			$this->serverAccessor->expects($this->any())->method('getValue')->with('argv')->willReturn(array('script', 'arg1', 'arg2'));

			$this->args = new Args($this->serverAccessor);

			$this->assertEquals(array('arg1', 'arg2'), $this->args->getArguments());
		}

		function testScriptWithOption()
		{
			$this->serverAccessor = $this->getMock('Saigon\Conpago\Accessor\ServerAccessor');
			$this->serverAccessor->expects($this->any())->method('contains')->with('argv')->willReturn(true);
			$this->serverAccessor->expects($this->any())->method('getValue')->with('argv')->willReturn(array('script', '-o1', 'option1'));

			$this->args = new Args($this->serverAccessor);

			$this->assertEquals(true, $this->args->hasOption('o1'));
			$this->assertEquals('option1', $this->args->getOption('o1'));
		}
	}
 