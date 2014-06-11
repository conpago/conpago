<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.02.14
	 * Time: 23:22
	 */

	namespace Saigon\Conpago\Commands;

	use Saigon\Conpago\ICommand;

	class HelpCommand implements ICommand
	{
		/**
		 * @var \Saigon\Conpago\IPresenter
		 */
		private $presenter;

		/**
		 * @param \DI\Meta[] $commands
		 * @param \Saigon\Conpago\IPresenter $presenter
		 *
		 * @inject Meta<\Saigon\Conpago\ICommand> $commands
		 * @inject \Saigon\Conpago\IPresenter $presenter
		 */
		function __construct(array $commands, IPresenter $presenter)
		{
			$this->commands = $commands;
			$this->presenter = $presenter;
		}

		function execute()
		{
			foreach ($this->commands as $key => $command)
			{
				$metaData = $command->getMetadata();
				$this->presenter->run(new StringPresenterModel($key.'     '.$metaData['desc'].PHP_EOL));
			}
		}
	}