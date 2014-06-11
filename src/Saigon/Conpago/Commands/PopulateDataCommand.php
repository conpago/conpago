<?php
	/**
	 * Created by PhpStorm.
	 * User: bartosz.golek
	 * Date: 22.01.14
	 * Time: 07:56
	 */

	namespace Saigon\Conpago\Commands;

	use Saigon\Conpago\ICommand;

	class PopulateDataCommand implements ICommand
	{
		/**
		 * @var \Saigon\Conpago\IUpgrade[]
		 */
		private $upgrades;

		/**
		 * @param \Saigon\Conpago\IUpgrade[] $upgrades
		 *
		 * @inject \Saigon\Conpago\IUpgrade $upgrades
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