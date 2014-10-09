<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-09
	 * Time: 20:16
	 */

	namespace Saigon\Conpago\Config;

	class ConfigBaseTest extends \PHPUnit_Framework_TestCase
	{
		public function test_()
		{
			$config = $this->getMock('Saigon\Conpago\Config\Contract\IConfig');
			$configBase = new TestConfigBase($config);
			$this->assertSame($config, $configBase->getConfig());
		}
	}

	class TestConfigBase extends ConfigBase
	{
		function getConfig()
		{
			return $this->config;
		}
	}