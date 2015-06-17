<?php
	/**
	 * Created by PhpStorm.
	 * User: bg
	 * Date: 10.10.14
	 * Time: 22:58
	 */

	namespace Saigon\Conpago\Helpers;


	class AppMaskTest extends \PHPUnit_Framework_TestCase
	{
		private $appPath;

		private $appMask;

		const SRC = 'src';

		const CONFIG = 'config';

		protected function setUp()
		{
			$this->appPath = $this->getMock('Saigon\Conpago\Helpers\Contract\IAppPath');
			$this->appPath->expects($this->any())->method('source')->willReturn(self::SRC);
			$this->appPath->expects($this->any())->method('config')->willReturn(self::CONFIG);

			$this->appMask = new AppMask($this->appPath);
		}

		public function testModuleMask()
		{
			$this->assertEquals(
				$this->buildPath(array(self::SRC,'*Module.php')),
				$this->appMask->moduleMask());
		}

		public function testConfigMask()
		{
			$this->assertEquals(
				$this->buildPath(array(self::CONFIG,'*.php')),
				$this->appMask->configMask()
			);
		}

		private function buildPath(array $array)
		{
			return implode(DIRECTORY_SEPARATOR, $array);
		}
	}
 