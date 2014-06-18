<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 14.11.13
	 * Time: 00:18
	 */

	namespace Saigon\Conpago\Core;

	use Saigon\Conpago\Commands\Contract\ICommand;
	use Saigon\Conpago\DI\Factory;
	use Saigon\Conpago\Exceptions\CommandNotFoundException;
	use Saigon\Conpago\Helpers\Contract\IArgs;
	use Saigon\Conpago\IApp;

	class ConsoleApp implements IApp
	{
		/**
		 * @var Factory[]
		 */
		private $commands;
		/**
		 * @var IArgs
		 */
		private $args;

		/**
		 * @param Factory[] $commands
		 * @param IArgs $args
		 *
		 * @inject Factory<\Saigon\Conpago\ICommand> $commands
		 * @inject \Saigon\Conpago\Helpers\IArgs $args
		 */
		function __construct(array $commands, IArgs $args)
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