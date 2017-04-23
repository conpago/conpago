<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-09
 * Time: 20:16
 */

namespace Conpago\Config;

use PHPUnit\Framework\TestCase;

class ConfigBaseTest extends TestCase
{
    public function test_()
    {
        $config = $this->createMock('Conpago\Config\Contract\IConfig');
        $configBase = new TestConfigBase($config);
        $this->assertSame($config, $configBase->getConfig());
    }
}

class TestConfigBase extends ConfigBase
{
    public function getConfig()
    {
        return $this->config;
    }
}
