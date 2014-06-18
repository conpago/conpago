<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 22.01.14
	 * Time: 07:56
	 */

	namespace Saigon\Conpago\Commands;

	use Saigon\Conpago\Commands\Contract\ICommand;
	use Saigon\Conpago\Upgrades\Contract\IUpgrade;

	class PopulateDataCommand implements ICommand
	{
		/**
		 * @var IUpgrade[]
		 */
		private $upgrades;

		/**
		 * @param IUpgrade[] $upgrades
		 *
		 * @inject IUpgrade $upgrades
		 */
		function __construct(array $upgrades)
		{
			$this->upgrades = $upgrades;
		}

		function execute()
		{
			foreach($this->upgrades as $upgrade)
				$upgrade->run();
		}
	}