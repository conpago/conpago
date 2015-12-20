<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 09.11.13
 * Time: 15:30
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Helpers;

use Conpago\Helpers\Contract\IPasswordHasher;

class SHA2PasswordHasher implements IPasswordHasher
{

    private $algorithm = 'sha512';

    /**
     * Calculate hash for given password.
     *
     * @param string $password Password to generate hash.
     *
     * @return string
     */
    public function calculateHash($password)
    {
        return hash($this->algorithm, $password);

    }
}
