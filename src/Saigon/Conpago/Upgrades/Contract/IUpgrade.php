<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 22.01.14
	 * Time: 07:59
	 */

	namespace Saigon\Conpago\Upgrades\Contract;


	interface IUpgrade
	{
		public function run();
	}