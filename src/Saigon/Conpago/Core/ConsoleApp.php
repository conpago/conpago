<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 14.11.13
	 * Time: 00:18
	 */

	namespace Saigon\Conpago\Core;

	use DI\Factory;
	use Saigon\Conpago\Exceptions\CommandNotFoundException;
	use Saigon\Conpago\IApp;
	use Saigon\Conpago\ICommand;
	use Saigon\Utils\Args;

	class ConsoleApp implements IApp
	{
		/**
		 * @var Factory[]
		 */
		private $commands;
		/**
		 * @var \Saigon\Utils\Args
		 */
		private $args;

		/**
		 * @param Factory[] $commands
		 * @param \Saigon\Utils\Args $args
		 *
		 * @inject Factory<\Saigon\Conpago\ICommand> $commands
		 * @inject \Saigon\Utils\Args $args
		 */
		function __construct(array $commands, Args $args)
		{
			$this->commands = $commands;
			$this->args = $args;
		}

		public function run()
		{
			$arguments = $this->args->getArguments();
			$commandName = $arguments[0];

			if (!array_key_exists($commandName, $this->commands))
			{
				throw new CommandNotFoundException("Command '".$commandName."' not found.");
			}

			/** @var Factory $commandFactory */
			$commandFactory = $this->commands[$commandName];
			/** @var ICommand $command */
			$command = $commandFactory->createInstance();
			$command->execute();
		}
	}