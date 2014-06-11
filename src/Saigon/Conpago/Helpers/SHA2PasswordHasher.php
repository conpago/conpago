<?php

	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\IPasswordHasher;

	class SHA2PasswordHasher implements IPasswordHasher
	{

		private $algo = 'sha512';

		public function getHash($password)
		{
			return hash($this->algo, $password);
		}

	}
