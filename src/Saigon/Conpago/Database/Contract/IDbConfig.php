<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Database\Contract;

	interface IDbConfig
	{
		public function getDriver();

		public function getUser();

		public function getPassword();

		public function getDbName();
	}