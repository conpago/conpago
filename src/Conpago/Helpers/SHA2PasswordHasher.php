<?php
    /**
     * Created by PhpStorm.
     * User: Bartosz Gołek
     * Date: 09.11.13
     * Time: 15:30
     */

    namespace Conpago\Helpers;

use Conpago\Helpers\Contract\IPasswordHasher;

    class SHA2PasswordHasher implements IPasswordHasher
    {

        private $algorithm = 'sha512';

        public function getHash($password)
        {
            return hash($this->algorithm, $password);
        }
    }
