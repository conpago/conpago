<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-19
	 * Time: 22:10
	 */

	namespace Saigon\Conpago\Core;

	class ConsoleAppTest extends \PHPUnit_Framework_TestCase
	{
		public function test_CreateConsoleApp()
		{
			$this->setExpectedException('Saigon\Conpago\Exceptions\CommandNotFoundException', 'Command \'\' not found.');
			$consoleApp = new ConsoleApp(array(), $this->getMock('Saigon\Conpago\Helpers\Contract\IArgs'));
			$consoleApp->run();
		}

		public function test_CreateConsoleAppWithFakeCommand()
		{
			$this->setExpectedException('Saigon\Conpago\Exceptions\CommandNotFoundException', 'Command \'fakeCommand\' not found.');
			$args = $this->getMock('Saigon\Conpago\Helpers\Contract\IArgs');
			$args->expects($this->any())->method('getArguments')->willReturn(array('fakeCommand'));
			$consoleApp = new ConsoleApp(array(), $args);
			$consoleApp->run();
		}

		public function test_CreateConsoleAppRunsCommand()
		{
			$args = $this->getMock('Saigon\Conpago\Helpers\Contract\IArgs');

			$command = $this->getMock('Saigon\Conpago\Commands\Contract\ICommand');
			$command->expects($this->once())->method('execute');

			$commandFactory = $this->getMock('Saigon\Conpago\DI\IFactory');
			$commandFactory->expects($this->once())->method('createInstance')->willReturn($command);

			$args->expects($this->any())->method('getArguments')->willReturn(array('realCommand'));
			$consoleApp = new ConsoleApp(array('realCommand' => $commandFactory), $args);
			$consoleApp->run();
		}
	}
