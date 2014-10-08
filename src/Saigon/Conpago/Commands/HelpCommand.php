<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.02.14
	 * Time: 23:22
	 */

	namespace Saigon\Conpago\Commands;

	use Saigon\Conpago\Commands\Contract\ICommand;
	use Saigon\Conpago\Commands\Contract\ICommandPresenter;

	class HelpCommand implements ICommand
	{
		/**
		 * @var ICommandPresenter
		 */
		private $presenter;

		/**
		 * @var array
		 */
		private $commandsMetadata;

		/**
		 * @param array $commandsMetadata
		 * @param ICommandPresenter $presenter
		 */
		function __construct(array $commandsMetadata, ICommandPresenter $presenter)
		{
			$this->commandsMetadata = $commandsMetadata;
			$this->presenter = $presenter;
		}

		function execute()
		{
			foreach ($this->commandsMetadata as $key => $metaData)
				$this->presenter->run($key . '     ' . $metaData['desc'] . PHP_EOL);
		}
	}