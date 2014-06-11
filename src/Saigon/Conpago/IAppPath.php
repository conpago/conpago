<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago;

	interface IAppPath
	{
		public function root($real = false);

		public function config($real = false);

		public function cache($real = false);

		public function templates($real = false);

		public function source($real = false);
	}
