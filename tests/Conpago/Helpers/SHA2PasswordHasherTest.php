<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-15
 * Time: 22:57
 */

namespace Conpago\Helpers;

use PHPUnit\Framework\TestCase;

class SHA2PasswordHasherTest extends TestCase
{
    public function testHash()
    {
        $hasher = new SHA2PasswordHasher();
        $this->assertEquals(hash('sha512', 'password'), $hasher->calculateHash('password'));
    }
}
