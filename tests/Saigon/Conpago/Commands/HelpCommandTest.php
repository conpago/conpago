<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-08
	 * Time: 18:17
	 */

	namespace Saigon\Conpago\Commands;

	use Saigon\Conpago\Commands\Contract\ICommandPresenter;

	class TestPresenter implements ICommandPresenter
	{
		var $result = "";

		public function run($string)
		{
			$this->result .= $string;
		}

		public function getResult()
		{
			return $this->result;
		}
	}

	class HelpCommandTest extends \PHPUnit_Framework_TestCase
	{
		public function testExecute()
		{
			$command1 = array('desc' => 'a');
			$command2 = array('desc' => 'b');
			$command3 = array('desc' => 'c');
			$commands = array($command1, $command2, $command3);

			$presenter = new TestPresenter();
			$expectedResult = '0     a'. PHP_EOL.'1     b'. PHP_EOL.'2     c'. PHP_EOL;

			$helpCommand = new HelpCommand($commands, $presenter);
			$helpCommand->execute();

			$this->assertEquals($expectedResult, $presenter->getResult());
		}
	}
