<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers\Contract;

	interface IAppPath
	{
		public function realRoot();

		public function realConfig();

		public function realCache();

		public function realTemplates();

		public function realSource();

		public function root();

		public function config();

		public function cache();

		public function templates();

		public function source();
	}
