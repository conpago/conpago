<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.02.14
	 * Time: 23:22
	 */

	namespace Saigon\Conpago\Commands;

	use Saigon\Conpago\ICommand;
	use Saigon\Conpago\ICommandPresenter;

	class HelpCommand implements ICommand
	{
		/**
		 * @var ICommandPresenter
		 */
		private $presenter;

		/**
		 * @param \DI\Meta[] $commands
		 * @param ICommandPresenter $presenter
		 *
		 * @inject Meta<\Saigon\Conpago\ICommand> $commands
		 * @inject ICommandPresenter $presenter
		 */
		function __construct(array $commands, ICommandPresenter $presenter)
		{
			$this->commands = $commands;
			$this->presenter = $presenter;
		}

		function execute()
		{
			foreach ($this->commands as $key => $command)
			{
				$metaData = $command->getMetadata();
				$this->presenter->run($key.'     '.$metaData['desc'].PHP_EOL);
			}
		}
	}