<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 22.01.14
	 * Time: 07:59
	 */

	namespace Saigon\Conpago;


	interface IUpgrade
	{
		public function run();
	}