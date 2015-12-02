<?php
    /**
     * Created by PhpStorm.
     * User: Bartosz Gołek
     * Date: 2014-10-09
     * Time: 20:16
     */

    namespace Conpago\Config;

class ConfigBaseTest extends \PHPUnit_Framework_TestCase
{
    public function test_()
    {
        $config = $this->getMock('Conpago\Config\Contract\IConfig');
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
