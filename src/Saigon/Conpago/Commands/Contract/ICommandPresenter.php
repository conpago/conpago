<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-15
	 * Time: 11:53
	 */

	namespace Saigon\Conpago\Commands\Contract;

	interface ICommandPresenter
	{
		public function run($string);
	}